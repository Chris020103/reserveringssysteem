<?php namespace Classes;

use Classes\DateOptions;
use Classes\User;

class Reservation
{
    public string $id;
    public string|DateOptions $date_id;
    public string|User $user_id;
    public string $date;
    public string $remarks;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Reservation
     */
    public function setId(string $id): Reservation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \Classes\DateOptions|string
     */
    public function getDateId(): string|\Classes\DateOptions
    {
        return $this->date_id;
    }

    /**
     * @param \Classes\DateOptions|string $date_id
     * @return Reservation
     */
    public function setDateId(string|\Classes\DateOptions $date_id): Reservation
    {
        $this->date_id = $date_id;
        return $this;
    }

    /**
     * @return \Classes\User|string
     */
    public function getUserId(): \Classes\User|string
    {
        return $this->user_id;
    }

    /**
     * @param \Classes\User|string $user_id
     * @return Reservation
     */
    public function setUserId(\Classes\User|string $user_id): Reservation
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return Reservation
     */
    public function setDate(string $date): Reservation
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemarks(): string
    {
        return $this->remarks;
    }

    /**
     * @param string $remarks
     * @return Reservation
     */
    public function setRemarks(string $remarks): Reservation
    {
        $this->remarks = $remarks;
        return $this;
    }

}