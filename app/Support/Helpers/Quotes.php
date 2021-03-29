<?php

if(!function_exists('generateQuote')) {
    function generateQuote() {
        $quotes = require resource_path('variables/quotes.php');
        $quote = $quotes[rand(0, count($quotes) - 1)];

        $quote['quote'] = \Illuminate\Support\Str::replaceFirst('}', '</span>', $quote['quote']);
        $quote['quote'] = \Illuminate\Support\Str::replaceFirst('{', '<span class="text-primary">', $quote['quote']);

        $output1 = '<h1 class="h3 d-block avenir-bold text-uppercase">"'.$quote['quote'].'"</h1>';
        $output2 = '<small class="d-block muted">~ '.$quote['author'].'</small>';

        return $output1 . $output2;
    }
}
