<?php

namespace App\Services;


use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_ConferenceSolutionKey;
use Google_Service_Calendar_CreateConferenceRequest;
use Carbon\Carbon;
class GoogleMeetService
{
    /**
     * Create a new class instance.
     */
    private $client;
    private $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        $this->service = new Google_Service_Calendar($this->client);
    }

    /**
     * Create Google Meet meeting with date and time
     *
     * @param string $title Meeting title
     * @param string $description Meeting description
     * @param string $date Date in Y-m-d format
     * @param string $startTime Time in H:i format
     * @param string $endTime Time in H:i format
     * @param string $timezone Timezone (default: UTC)
     * @param array $attendees Array of email addresses
     * @return array Meeting details including Google Meet link
     */
    public function createMeeting($title, $description, $date, $startTime, $endTime, $timezone = 'UTC', $attendees = [])
    {
        try {
            // Set access token (you need to handle OAuth flow separately)
            $accessToken = $this->getStoredAccessToken();

            $this->client->setAccessToken($accessToken);

            // Check if token is expired and refresh if needed
            if ($this->client->isAccessTokenExpired()) {
                $this->refreshAccessToken();
            }

            // Create DateTime objects
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $startTime, $timezone);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $endTime, $timezone);

            // Create event
            $event = new Google_Service_Calendar_Event([
                'summary' => $title,
                'description' => $description,
                'start' => [
                    'dateTime' => $startDateTime->toRfc3339String(),
                    'timeZone' => $timezone,
                ],
                'end' => [
                    'dateTime' => $endDateTime->toRfc3339String(),
                    'timeZone' => $timezone,
                ],
                'attendees' => array_map(function($email) {
                    return ['email' => $email];
                }, $attendees),
                'conferenceData' => [
                    'createRequest' => [
                        'requestId' => uniqid(),
                        'conferenceSolutionKey' => [
                            'type' => 'hangoutsMeet'
                        ]
                    ]
                ],
                'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                        ['method' => 'email', 'minutes' => 24 * 60],
                        ['method' => 'popup', 'minutes' => 10],
                    ],
                ],
            ]);

            // Insert event with conference data
            $calendarId = 'primary';
            $event = $this->service->events->insert($calendarId, $event, [
                'conferenceDataVersion' => 1,
                'sendUpdates' => 'all'
            ]);

            return [
                'success' => true,
                'event_id' => $event->getId(),
                'html_link' => $event->getHtmlLink(),
                'meet_link' => $event->getConferenceData() ?
                    $event->getConferenceData()->getEntryPoints()[0]->getUri() : null,
                'start_time' => $startDateTime->toDateTimeString(),
                'end_time' => $endDateTime->toDateTimeString(),
                'event' => $event
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get meetings for a specific date
     *
     * @param string $date Date in Y-m-d format
     * @param string $timezone Timezone
     * @return array List of meetings
     */
    public function getMeetingsForDate($date, $timezone = 'UTC')
    {
        try {
            $accessToken = $this->getStoredAccessToken();
            $this->client->setAccessToken($accessToken);

            if ($this->client->isAccessTokenExpired()) {
                $this->refreshAccessToken();
            }

            $startOfDay = Carbon::createFromFormat('Y-m-d', $date, $timezone)->startOfDay();
            $endOfDay = Carbon::createFromFormat('Y-m-d', $date, $timezone)->endOfDay();

            $optParams = [
                'timeMin' => $startOfDay->toRfc3339String(),
                'timeMax' => $endOfDay->toRfc3339String(),
                'singleEvents' => true,
                'orderBy' => 'startTime',
            ];

            $results = $this->service->events->listEvents('primary', $optParams);
            $events = $results->getItems();

            $meetings = [];
            foreach ($events as $event) {
                if ($event->getConferenceData()) {
                    $meetings[] = [
                        'id' => $event->getId(),
                        'title' => $event->getSummary(),
                        'description' => $event->getDescription(),
                        'start_time' => $event->getStart()->getDateTime(),
                        'end_time' => $event->getEnd()->getDateTime(),
                        'meet_link' => $event->getConferenceData()->getEntryPoints()[0]->getUri(),
                        'html_link' => $event->getHtmlLink()
                    ];
                }
            }

            return [
                'success' => true,
                'meetings' => $meetings
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get authorization URL for OAuth
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Handle OAuth callback and store tokens
     */
    public function handleCallback($code)
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            throw new \Exception('Error fetching access token: ' . $token['error']);
        }

        // Store tokens in database or session
        $this->storeAccessToken($token);

        return $token;
    }

    /**
     * Store access token (implement based on your storage preference)
     */
    private function storeAccessToken($token)
    {
        // Example: Store in session
        session(['google_access_token' => $token]);

        // Or store in database for the authenticated user
        // auth()->user()->update(['google_access_token' => json_encode($token)]);
    }

    /**
     * Get stored access token
     */
    private function getStoredAccessToken()
    {
        // Example: Get from session
        return session('google_access_token');

        // Or get from database
        // return json_decode(auth()->user()->google_access_token, true);
    }

    /**
     * Refresh access token
     */
    private function refreshAccessToken()
    {
        $token = $this->getStoredAccessToken();

        if (isset($token['refresh_token'])) {
            $this->client->refreshToken($token['refresh_token']);
            $newToken = $this->client->getAccessToken();
            $this->storeAccessToken($newToken);
        }
    }
}
