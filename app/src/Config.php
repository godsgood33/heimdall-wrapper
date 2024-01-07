<?php

/**
 * Config class
 *
 * @author Ryan Prather <ryan@rkprather.com>
 */
class Config
{
    /**
     * Class data
     *
     * @var stdClass
     */
    private ?stdClass $data = null;

    /**
     * Constructor
     *
     * @param string $json
     */
    public function __construct(string $json)
    {
        $this->data = json_decode($json);
    }

    /**
     * Method to get the string to access Heimdall
     *
     * @return string
     */
    public function getHeimdallString(): string
    {
        $port = ":".$this->data->heimdall->port;
        if ($this->data->heimdall->proto == 'https' && $this->data->heimdall->port == 443) {
            $port = null;
        } elseif ($this->data->heimdall->proto == 'http' && $this->data->heimdall->port == 80) {
            $port = null;
        }
        return "{$this->data->heimdall->proto}://{$this->data->heimdall->ip}{$port}";
    }

    /**
     * Get the title of the site
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->data->title;
    }

    /**
     * Get array of users
     *
     * @return array
     */
    public function getUsers(): array
    {
        $users = [];
        foreach($this->data->users as $u => $d) {
            $users[] = $u;
        }
        return $users;
    }

    /**
     * Get list of tags the user wants
     *
     * @param string $user
     *
     * @return array
     */
    public function getUserTags(string $user): array
    {
        $user = strtolower($user);
        return $this->data->users?->{$user}?->tags ?? [];
    }

    /**
     * Method to get the users home tag
     *
     * @param string $user
     *
     * @return string
     */
    public function getUserHomeTag(string $user): string
    {
        $user = strtolower($user);
        return $this->data->users?->{$user}?->homeTag ?? "";
    }
}
