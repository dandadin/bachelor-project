<?php

class PermissionManager {
    private array|null $permissions;
    static public PermissionManager $instance;

    public function __construct(int $userId) {
        PermissionManager::$instance = $this;
        if ($userId <= 0) {
            $this->permissions = null;
            return;
        }
        $this->permissions = array();

        $sql = "SELECT * from domain_users left join roles r on r.id = domain_users.role_id WHERE user_id=".$userId;
        $sqls=DB::query($sql);
        while($o=$sqls->fetchObject()) {
            $this->permissions[$o->domain_id]["can_edit_colls"] |= $o->can_edit_colls;
            $this->permissions[$o->domain_id]["can_edit_users"] |= $o->can_edit_users;
            $this->permissions[$o->domain_id]["can_edit_devices"] |= $o->can_edit_devices;
            $this->permissions[$o->domain_id]["can_edit_gateways"] |= $o->can_edit_gateways;
            $this->permissions[$o->domain_id]["can_list_colls"] |= $o->can_list_colls;
            $this->permissions[$o->domain_id]["can_list_users"] |= $o->can_list_users;
            $this->permissions[$o->domain_id]["can_list_devices"] |= $o->can_list_devices;
            $this->permissions[$o->domain_id]["can_list_gateways"] |= $o->can_list_gateways;
            $this->permissions[$o->domain_id]["can_edit_all"] |= $o->can_edit_all;
        }
    }

    public function setPermissions(int $domainId, bool $CLColls, bool $CEColls, bool $CLUsers, bool $CEUsers,
                                   bool $CLDevices, bool $CEDevices, bool $CLGateways, bool $CEGateways,
                                   bool $CEAll) : void {
        if (!isset($this->permissions)) $this->permissions = array();
        $this->permissions[$domainId]["can_edit_colls"] |= $CEColls;
        $this->permissions[$domainId]["can_edit_users"] |= $CEUsers;
        $this->permissions[$domainId]["can_edit_devices"] |= $CEDevices;
        $this->permissions[$domainId]["can_edit_gateways"] |= $CEGateways;
        $this->permissions[$domainId]["can_list_colls"] |= $CLColls;
        $this->permissions[$domainId]["can_list_users"] |= $CLUsers;
        $this->permissions[$domainId]["can_list_devices"] |= $CLDevices;
        $this->permissions[$domainId]["can_list_gateways"] |= $CLGateways;
        $this->permissions[$domainId]["can_edit_all"] |= $CEAll;
    }

    public function getPermissions(int $domainId) : array {
        if (!isset($this->permissions) || !isset($this->permissions[$domainId]))
            return ["can_edit_colls" => false, "can_edit_users" => false,
                    "can_edit_devices" => false, "can_edit_gateways" => false,
                    "can_list_colls" => false, "can_list_users" => false,
                    "can_list_devices" => false, "can_list_gateways" => false,
                    "can_edit_all" => false];
        return $this->permissions[$domainId];
    }

    public function getDomainsByPerm(string $permName) : array|null {
        if (!$permName) return null;
        $res = array();
        if (!isset($this->permissions)) return $res;
        foreach ($this->permissions as $key => $dom) {
            if ($dom[$permName]) $res[] = $key;
        }
        return $res;
    }

    public function canEditAll() : bool {
        foreach ($this->permissions as $key => $dom) {
            if ($dom["can_edit_all"]) return true;
        }
        return false;
    }

    public function getAllDomains() : array {
        $res = array();
        foreach ($this->permissions as $key => $dom) $res[] = $key;
        return $res;
    }

    public function checkDomainPerm(int $domainId, string $permName) : bool {
        if (!isset($this->permissions)) return false;
        if (!isset($this->permissions[$domainId])) return false;
        if (!isset($this->permissions[$domainId][$permName])) return false;
        return $this->permissions[$domainId][$permName];
    }

    public static function arrayToSQL(array|null $array) : string {
        if (!$array) return "(-1)";
        $res = "(";
        $first = true;
        foreach ($array as $value) {
            if ($first) $first = false; else $res .= ", ";
            $res .= $value;
        }
        $res .= ")";
        return $res;
    }
}