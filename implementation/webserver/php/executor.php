<?php

$time = time();
$sqls=DB::query("SELECT * FROM instances WHERE step_ts<'".timetostr($time)."' ORDER BY step_ts");


while($o=$sqls->fetchObject()) {
        Communicator::sendStep($o->step_id);
        nextStep($o->id, $time);
}
$sql="SELECT instances.*, UNIX_TIMESTAMP(step_ts)-".$time." AS reload FROM instances ORDER BY reload LIMIT 1";
$sqls=DB::query($sql);
$o=$sqls->fetchObject();
//echo "NEW INSTANCE ID:".$o->id.", STEP: ".$o->step_id.", TS: ".$o->step_ts."<br>";
//echo "<h2>Dalsi reload udelej za: ".(max($o->reload, 0))."</h2>";
echo (max(min($o->reload, 30), 0));

/**
 * Tries to push instance $instanceId to the next step. If no next step found, deletes the instance.
 * @param int $instanceId Id of instance to be pushed.
 * @param int $timeNow Time of recently completed active step.
 * @return bool Success of persisting.
 */
function nextStep(int $instanceId, int $timeNow) {
    $sql = "SELECT instances.*, s.idx AS sidx FROM instances LEFT JOIN steps s on s.id = instances.step_id WHERE instances.id=$instanceId";
    $sqls=DB::query($sql);
    $oInstance=$sqls->fetchObject();
    $sql = "SELECT * FROM steps WHERE idx>$oInstance->sidx AND steps.seq_id=$oInstance->seq_id ORDER BY idx LIMIT 1";
    $sqls=DB::query($sql);
    $oStep=$sqls->fetchObject();
    $res = true;
    if ($oStep) {
        $sql = "UPDATE instances SET step_id=:step_id, step_ts=:step_ts WHERE id=$instanceId";
        $sqls=DB::prepare($sql);
        $newTime = timetostr($timeNow + $oStep->delay_before);
        try {$res = $sqls->execute(["step_id" => $oStep->id, "step_ts" => $newTime]);
        } catch (PDOException $e) {

            error_log("executor.php: ".$e->getMessage().".");
            return false;
        }
    } else {
        $sqls=DB::prepare("DELETE FROM instances WHERE id=$instanceId");
        try {$res = $sqls->execute([]);
        } catch (PDOException $e) {
            error_log("executor.php: ".$e->getMessage().".");
            return false;
        }
    }
    return $res;
}
