<?php
namespace WFN\Admin\Model;

class Alert
{

    public static function flush()
    {
        \Session::remove('messages');
    }

    public static function getMessages()
    {
        return \Session::has('messages') ? \Session::get('messages') : [];
    }

    public static function addError($message)
    {
        self::_addMessage('danger', $message);
    }

    public static function addInfo($message)
    {
        self::_addMessage('info', $message);
    }

    public static function addWarning($message)
    {
        self::_addMessage('warning', $message);
    }

    public static function addSuccess($message)
    {
        self::_addMessage('success', $message);
    }

    protected static function _addMessage($type, $message)
    {
        \Session::push('messages', [
            'type' => $type,
            'text' => $message
        ]);
    }

}