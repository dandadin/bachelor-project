<?php

/**
 * View for table row that renders info (mainly devices and channels) about gateway details loaded acquired from the gateway json config file.
 */
class VPTRGatewayJson extends VPTableRow {

    /**
     * Constructs row of table, that shows info about loaded devices and channels.
     * @param $json array Row from json with data about one device.
     */
    public function __construct($json) {
        if (!$json) error_log("Error! Json not provided.");
        $this->add(new VText($json["name"]));
        $this->add(new VText($json["location"]));
        $channels = "";
        $first = true;
        foreach ($json["channels"] as $channel) {
            if ($first) $first = false;
            else $channels .= ", ";
            $channels .= $channel["name"];
        }
        $this->add(new VText($channels));
        parent::__construct();
    }
}