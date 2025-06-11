<?php

namespace App\Helper;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class GreetingHelper
{
    public static function getGreeting(): string
    {
        $sessionKey = 'user_greeting_' . Auth::id();
        $currentHour = now()->format('H');

        $sessionData = session()->get($sessionKey);
        $shouldRefreshGreeting = !$sessionData ||
            $sessionData['hour'] !== $currentHour ||
            $sessionData['session_id'] !== Session::getId();

        if ($shouldRefreshGreeting) {
            $timeOfDay = match (true) {
                $currentHour < 12 => 'morning',
                $currentHour < 18 => 'afternoon',
                default => 'evening'
            };

            $greetings = [
                'morning' => [
                    'Good morning',
                    'Welcome back',
                    'Hello there'
                ],
                'afternoon' => [
                    'Good afternoon',
                    'Hi there',
                    'Good to see you',
                ],
                'evening' => [
                    'Good evening',
                    'Greetings',
                    'Hey there',
                ]
            ];

            $greeting = $greetings[$timeOfDay][array_rand($greetings[$timeOfDay])];

            session()->put($sessionKey, [
                'greeting' => $greeting,
                'hour' => $currentHour,
                'session_id' => Session::getId()
            ]);

            return $greeting;
        }

        return $sessionData['greeting'];
    }
}
