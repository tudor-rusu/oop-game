<?php

namespace app\components;

/**
 * Class for flash messages using sessions
 */
class FlashMessages
{
    /**
     * @var string
     */
    const INFO = 'info';

    /**
     * @var string
     */
    const SUCCESS = 'success';

    /**
     * @var string
     */
    const WARNING = 'warning';

    /**
     * @var string
     */
    const ERROR = 'danger';

    /**
     * @var string
     */
    const DEFAULT_TYPE = self::INFO;

    /**
     * @var string|null
     */
    protected $redirectUrl = null;

    /**
     * FlashMessages constructor.
     */
    public function __construct()
    {
        if (!array_key_exists('flash_messages', $_SESSION)) {
            $_SESSION['flash_messages'] = [];
        }
    }

    /**
     * Check if there is any flash messages
     *
     * @param null $type
     *
     * @return bool|mixed
     */
    public function hasMessages($type = null)
    {
        if (!empty($_SESSION['flash_messages'])) {
            if (!empty($_SESSION['flash_messages'][$type])) {
                return $_SESSION['flash_messages'][$type];
            }

            return $_SESSION['flash_messages'];
        }

        return false;
    }

    /**
     * Add a flash message to the session data
     *
     * @param        $message
     * @param string $type
     * @param null   $redirectUrl
     *
     * @return $this|bool
     */
    public function addMessage($message, $type = self::DEFAULT_TYPE, $redirectUrl = null)
    {
        if (!isset($message[0])) {
            return false;
        }

        if (!array_key_exists($type, $_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'][$type] = [];
        }

        $_SESSION['flash_messages'][$type][] = ['message' => $message];

        if (!is_null($redirectUrl)) {
            $this->redirectUrl = $redirectUrl;
            $this->redirect();
        }

        return $this;
    }

    /**
     * Clear the messages from the session data
     *
     * @param array|string $types
     *
     * @return $this
     */
    public function clear($types = [])
    {
        if ((is_array($types) && empty($types)) || !$types) {
            unset($_SESSION['flash_messages']);
        } elseif (!is_array($types)) {
            $types = [$types];
        }

        foreach ($types as $type) {
            unset($_SESSION['flash_messages'][$type]);
        }

        return $this;
    }

    /**
     * Redirect if redirectUrl was provided
     *
     * @return $this
     */
    private function redirect()
    {
        if ($this->redirectUrl) {
            header('Location: ' . $this->redirectUrl);
            exit();
        }
        return $this;
    }
}