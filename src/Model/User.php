<?php


namespace App\Model;


class User
{
    /** @var string $nickName */
    protected $nickName;

    /**
     * User constructor.
     * @param string $nickName
     */
    public function __construct(string $nickName)
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

}