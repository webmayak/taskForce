<?php

class task
{
    public const STATUS_NEW = 'status_new';
    public const STATUS_CANCELED = 'status_canceled';
    public const STATUS_INWORK = 'status_inwork';
    public const STATUS_DONE = 'status_done';
    public const STATUS_FAILED = 'status_failed';

    public const ACTION_CANCEL = 'action_cancel';
    public const ACTION_RESPOND = 'action_respond';
    public const ACTION_PERFORMED = 'action_performed';
    public const ACTION_REFUSE = 'action_refuse';

    public $idApplicant;
    public $idEmployer;
    public $status;

    public function __construct($idEmployer, $idApplicant)
    {
        $this->idApplicant = $idApplicant;
        $this->idEmployer = $idEmployer;
        $this->status = self::STATUS_NEW;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function availableActions(int $id)
    {
        if ($this->status == self::STATUS_NEW) {
            if ($id == $this->idEmployer) {
                return self::ACTION_CANCEL;
            } else {
                return self::ACTION_RESPOND;
            }
        } elseif ($this->status == self::STATUS_INWORK) {
            if ($id == $this->idEmployer) {
                return self::ACTION_PERFORMED;
            } else {
                return self::ACTION_REFUSE;
            }
        }
    }

    public function getNextStatus(string $action)
    {
        if ($this->status == self::STATUS_NEW) {
            if ($action == self::ACTION_CANCEL) {
                return self::STATUS_CANCELED;
            } elseif ($action == self::ACTION_RESPOND) {
                return self::STATUS_INWORK;
            } else {
                return "данное действие невозможно выполнить при данном статусе задания";
            }
        } elseif ($this->status == self::STATUS_INWORK) {
            if ($action == self::ACTION_PERFORMED) {
                return self::STATUS_DONE;
            } elseif ($action == self::ACTION_REFUSE) {
                return self::STATUS_FAILED;
            } else {
                return "данное действие невозможно выполнить при данном статусе задания";
            }
        }
    }
}

$task = new task(25, 44);
print_r($task->getStatus());
print_r($task->availableActions(25));
print_r($task->availableActions(44));
print_r($task->getNextStatus('action_refuse'));
