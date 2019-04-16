<?php


namespace App\Model;


class User implements \JsonSerializable
{
    /** @var string $nickName */
    protected $nickName;

    /**
     * User constructor.
     * @param string $nickName
     */
    public function __construct(string $nickName = '')
    {
        $this->nickName = $nickName;
    }

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nickName;
    }

    /**
     * @param string $nickName
     */
    public function setNickName(string $nickName): void
    {
        $this->nickName = $nickName;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'nickName' => $this->nickName,
        );
    }

    /**
     * @return mixed
     */
    public function __toString() {
        return $this->nickName;
    }
}