<?php

class VNotification extends VView {
    const NT_Error = "notif-error";
    const NT_Success = "notif-success";
    const NT_Info = "notif-info";
    const Icons = [ "notif-error" => "fa-xmark",
                    "notif-success" => "fa-check",
                    "notif-info" => "fa-info"];

    protected $type;
    protected $message;

    public function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;
    }

    protected function renderBody(): void {
        parent::renderBody(); // TODO: Change the autogenerated stub
        echo "<div class='notif $this->type'>";
        echo "<span><i class=\"fa-solid ".VNotification::Icons[$this->type]."\"></i>$this->message</span>";
        echo "</div>\n";
    }


}
