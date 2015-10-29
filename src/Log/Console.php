<?php
namespace Dfi\TestUtils\Log;

use ArrayAccess;

class Console implements ArrayAccess
{
    protected $lines = [];
    protected $start;
    protected $duration;
    protected $retrieved;

    protected function __construct($start, $duration, $retrieved)
    {
        $this->start = $start;
        $this->duration = $duration;
        $this->retrieved = $retrieved;
    }

    public static function parseLog($log)
    {
        $lines = explode("\n", $log);

        $start = self::cleanStartLine(array_shift($lines));
        array_shift($lines);

        //$end = array_pop($lines);
        $duration = self::cleanStartLine(array_pop($lines));
        $retrieved = self::cleanStartLine(array_pop($lines));
        array_pop($lines);

        $console = new Console($start, $duration, $retrieved);

        foreach ($lines as $line) {
            $console->addLine(Line::parseLine($line));
        }
        return $console;
    }

    private static function cleanStartLine($line)
    {
        $line = trim(str_replace('----', '', $line));
        $time = trim(substr($line, strpos($line, ':') + 1));
//        $x = date_create($time);

        return $time;
    }


    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    public function addLine(Line $line)
    {
        $this->lines[] = $line;
    }


    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function __toString()
    {
        $out = $this->lines;
        return implode("\n", $out);
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getRetrieved()
    {
        return $this->retrieved;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }



}