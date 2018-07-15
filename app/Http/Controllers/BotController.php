<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * @param Request $request
     */
    public function bot(Request $request){

        $data=$request->all();
        $senderId     =$data["entry"][0]["messaging"][0]["sender"]["id"];
        $senderMessage =$data["entry"][0]["messaging"][0]['message']["text"];

        if(!empty($senderMessage))
        {
            $this->SendTypingMsg($senderId);
            $message = $this->GenerateMessgae($senderId,$senderMessage);
            $this->SendResponse($message);
            if($senderMessage == "Not Sure."){
                $this->SendTypingMsg($senderId);
                $message = $this->GenerateMessgae($senderId,"Second Mood");
                $this->SendResponse($message);
            }
        }

    }

    /**
     * @param $senderId
     * @param $senderMessage
     * @return array|string
     */
    private function GenerateMessgae($senderId, $senderMessage){
        $botMessage="";
        if($senderMessage == "Fine."){
            $botMessage=[
                "recipient" => [
                    "id" => $senderId,
                ],
                "message"   => [
                    "text" => 'Great, Let me inform you something. :)',
                    "quick_replies" => [
                        [
                            "content_type"=>"text",
                            "title"=> "This Bot Project.",
                            "payload"=>"This Bot Project.",
                        ],
                        [
                            "content_type"=>"text",
                            "title"=> "Author.",
                            "payload"=>"Author.",
                        ]
                    ],
                ],
            ];
        }else if($senderMessage == "Not Sure."){
            $botMessage=[
                "recipient" => [
                    "id" => $senderId,
                ],
                "message"   => [
                    "attachment" => [
                        "type" => "template",
                        "payload" => [
                            "template_type" => "media",
                            "elements" => [
                                [
                                    "media_type" => "video",
                                    "url" => "https://www.facebook.com/CheesasOfUET/videos/2108757349199245/",
                                    "buttons" => [
                                        [
                                            "type" => "web_url",
                                            "url" => "https://www.facebook.com/pg/CheesasOfUET/videos/",
                                            "title" => "View More..",
                                        ],
                                        [
                                            "type" => "web_url",
                                            "url" => "https://www.facebook.com/ProgrammersCreateLife/videos/",
                                            "title" => "And View More...",
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }else if($senderMessage == "Second Mood"){
            $botMessage=[
                "recipient" => [
                    "id" => $senderId,
                ],
                "message"   => [
                    "text" => "What about Now ??",
                    "quick_replies" => [
                        [
                            "content_type"=>"text",
                            "title"=> "Fine.",
                            "payload"=>"Fine.",
                        ],
                        [
                            "content_type"=>"text",
                            "title"=> "Not Sure.",
                            "payload"=>"Not Sure.",
                        ]
                    ],
                ],
            ];

        }else if($senderMessage == "Author."){

            $botMessage=[
                "recipient" => [
                    "id" => $senderId
                ],
                "message" => [
                    "attachment" => [
                        "type" => "template",
                        "payload" => [
                            "template_type" => "list",
                            "elements" => [
                                [
                                    "title" => "GitHub",
                                    "subtitle" => "Explore my GitHub account and see latest contribution.",
                                    "image_url" => "https://avatars3.githubusercontent.com/u/16000186?s=400&v=4",
                                    "buttons" => [
                                        [
                                            "type" => "web_url",
                                            "url" => "https://github.com/Jaggesher",
                                            "title" => "View",
                                        ],
                                    ],
                                ],
                                [
                                    "title" => "LinkedIn",
                                    "subtitle" => "Connect me in LinkedIn.",
                                    "image_url" => "https://avatars3.githubusercontent.com/u/16000186?s=400&v=4",
                                    "buttons" => [
                                        [
                                            "type" => "web_url",
                                            "url" => "https://www.linkedin.com/in/jaggesher/",
                                            "title" => "View",
                                        ],
                                    ],
                                ],
                                [
                                    "title" => "UVA",
                                    "subtitle" => "See some of my problem solving.",
                                    "image_url" => "https://avatars3.githubusercontent.com/u/16000186?s=400&v=4",
                                    "buttons" => [
                                        [
                                            "type" => "web_url",
                                            "url" => "http://uhunt.onlinejudge.org/id/570234",
                                            "title" => "View",
                                        ],
                                    ],
                                ],
                                [
                                    "title" => "Facebook",
                                    "subtitle" => "Let's be friend.",
                                    "image_url" => "https://avatars3.githubusercontent.com/u/16000186?s=400&v=4",
                                    "buttons" => [
                                        [
                                            "type" => "web_url",
                                            "url" => "https://www.facebook.com/jaggeshar.mondal",
                                            "title" => "View",
                                        ],
                                    ],
                                ]
                            ],
                            "buttons" => [
                                [
                                    "type" => "web_url",
                                    "url" => "https://jaggesher.github.io/",
                                    "title" => "My Portfolio",
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }else if($senderMessage == "This Bot Project."){

            $botMessage=[
                "recipient" => [
                    "id" => $senderId,
                ],
                "message"   => [
                    "attachment" => [
                        "type" => "template",
                        "payload" => [
                            "template_type" => "generic",
                            "elements" => [
                                [
                                    "title"=>"Welcome To jkmbot!",
                                    "image_url"=>"https://avatars3.githubusercontent.com/u/16000186?s=400&v=4",
                                    "subtitle" => "The purpose of this project is to pass technical test of MCC Ltd.",
                                    "default_action" => [
                                        "type" => "web_url",
                                        "url" => "https://github.com/Jaggesher/jkmbot",
                                        "webview_height_ratio" => "tall",
                                    ],
                                    "buttons" => [
                                        [
                                            "type" => "web_url",
                                            "url" => "http://mcc.com.bd/",
                                            "title" => "MCC Ltd",
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];

        } else{
            $message = $this->GreetingMessage($senderId);
            $botMessage=[
                "recipient" => [
                    "id" => $senderId,
                ],
                "message"   => [
                    "text" => $message,
                    "quick_replies" => [
                        [
                            "content_type"=>"text",
                            "title"=> "Fine.",
                            "payload"=>"Fine.",
                        ],
                        [
                            "content_type"=>"text",
                            "title"=> "Not Sure.",
                            "payload"=>"Not Sure.",
                        ]
                    ],
                ],
            ];
        }

        return $botMessage;
    }

    /**
     * @param $messgae
     */
    private function SendResponse($messgae){
        $cu = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=' . env("PAGE_ACCESS_TOKEN"));
        curl_setopt($cu, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($cu, CURLOPT_POST, true);
        curl_setopt($cu, CURLOPT_POSTFIELDS, json_encode($messgae));
        curl_exec($cu);
        curl_close($cu);
    }

    /**
     * @param $senderId
     * @return string
     */
    private function GreetingMessage($senderId){

        $cSession = curl_init();
        curl_setopt($cSession,CURLOPT_URL,'https://graph.facebook.com/v2.6/'.$senderId.'?fields=last_name,gender&access_token=' . env("PAGE_ACCESS_TOKEN"));
        curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cSession,CURLOPT_HEADER, false);
        $data=curl_exec($cSession);
        curl_close($cSession);

        $message='';

        $hour = date('H') + 6;
        $greetings = "";

        if ($hour >= 20) {
            $greetings = "Good Night";
        } elseif ($hour > 17) {
            $greetings = "Good Evening";
        } elseif ($hour > 11) {
            $greetings = "Good Afternoon";
        } elseif ($hour < 12) {
            $greetings = "Good Morning";
        }
        $data = json_decode($data,true);

        if($data["gender"] == "male") $message .= $greetings.", Mr ".$data["last_name"].'. How are you? :) ';
        else $message .= $greetings.", Mrs ".$data["last_name"].'. How are you? :) ';
        return $message;

    }

    /**
     * @param $senderId
     */
    private function SendTypingMsg($senderId){
        $botMessage=[
            "recipient" => [
                "id" => $senderId,
            ],
            "sender_action" => "typing_on",
        ];
        $this->SendResponse($botMessage);
    }
}
