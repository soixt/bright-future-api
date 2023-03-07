<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mailgun\Mailgun;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;

class Presentation extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public static function dispatch ($users, $user, $template) {
        $emails = [];
        $variables = [];
        $count = 0;
        $batches = [];
        foreach ($users as $u) {
            $variables[$u->email] = ['name' => $u->name, 'hash' => $u->stop];
            array_push($emails, $u->email);
            $count = $count + 1;
            if ($count === 900) {
                array_push($batches, [
                    'emails' => $emails,
                    'variables' => $variables
                ]);
                $count = 0;
                $emails = [];
                $variables = [];
            }
        }

        if (empty($batches)) {
            array_push($batches, [
                'emails' => $emails,
                'variables' => $variables
            ]);
        }

        foreach ($batches as $batch) {
            $result = Mailgun::create(config('services.mailgun.secret'), config('services.mailgun.endpoint'))->messages()->send(config('services.mailgun.domain'), array(
                'from'    => 'Bright Future <no-reply@brightfuture.rs>',
                'to'      => $batch['emails'],
                'subject' => $user->name . ' - ' . $user->sports->first()->name,
                'reply-to'    => $user->name . ' <' . $user->email . '>',
                'text'    => 'Dear %recipient.name%, If you got this message without HTML, just skip it.',
                'recipient-variables' => json_encode($batch['variables']),
                'html' =>  new HtmlString($template)
            ));
        }
    }
}
