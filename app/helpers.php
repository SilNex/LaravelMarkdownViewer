<?php
function markdown($text)
{
    return app(ParsedownExtra::class)->text($text);
}