<?php
namespace Dfi\TestUtils\Log;


class Line
{
    protected $time;
    protected $severity;
    protected $message;

    public function __construct($time, $severity, $message)
    {
        $this->time = $time;
        $this->severity = $severity;
        $this->message = $message;

    }

    public static function parseLine($log)
    {


        if (preg_match('/\[(.*)\].*(\[.*\])/', $log, $matches)) {
            $x = json_decode(trim($matches[2]));
            if (!array_key_exists(1, $matches) || !array_key_exists(0, $x) || !array_key_exists(1, $x)) {
                throw new \DomainException('parse failed');
            }
            $line = new Line($matches[1], $x[0], $x[1]);
            return $line;
        }

        throw new \DomainException('parse failed');
    }

    public function __toString()
    {
        return $this->time . ' ' . $this->severity . ' ' . $this->message;
    }
}
