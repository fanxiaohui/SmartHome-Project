<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include "functions.php";

$action = $_GET['action'];
$table = $_GET['table'];
$db = connectDB();
try {
    if ($table == "rooms") {
        if ($action == "new") {
            $roomName = $_GET['roomName'];
            $topicName = $_GET['topicName'];
            $roomName = str_replace("'", "''", $roomName);

            $db->exec("INSERT INTO 'Rooms' ('Name', 'TopicName') VALUES ('" . $roomName . "','" . $topicName . "')");
            $db = null;
            if (REDIRECTS) {
                header('Location: /rooms');
            }
            echo "success";
        } elseif ($action == "delete") {
            $id = intval($_GET['id']);
            $db->exec("DELETE FROM 'Rooms' where Id = '" . $id . "'");
            $db = null;
            if (REDIRECTS) {
                header('Location: /rooms');
            }
            echo "success";
        } elseif ($action == "edit") {
            $roomName = $_GET['roomName'];
            $topicName = $_GET['topicName'];
            $id = intval($_GET['id']);
            $roomName = str_replace("'", "''", $roomName);
            $db->exec("UPDATE 'Rooms' SET Name='" . $roomName . "', TopicName='" . $topicName . "' WHERE Id='" . $id . "'");
            $db = null;
            if (REDIRECTS) {
                header('Location: /rooms');
            }
            echo "success";
        }
    } elseif ($table == "devs") {
        if ($action == "new") {
            $id = $_GET['Id'];
            $Name = $_GET['Name'];
            $Roomid = intval($_GET['roomid']);
            $devtypeid = intval($_GET['devid']);

            $db->exec("INSERT INTO 'Devices' ('Id', 'TypeId', 'Name', 'RoomId') VALUES ('" . $id . "','" . $devtypeid . "','" . $Name . "','" . $Roomid . "')");
            $db = null;
            if (REDIRECTS) {
                header('Location: /devices');
            }
            echo "success";
        } elseif ($action == "delete") {
            $id = $_GET['id'];
            $db->exec("DELETE FROM 'Devices' where Id = '" . $id . "'");
            $db = null;
            if (REDIRECTS) {
                header('Location: /devices');
            }
            echo "success";
        } elseif ($action == "edit") {
            $id = $_GET['id'];
            $Name = $_GET['Name'];
            $Roomid = intval($_GET['roomid']);
            $devtypeid = intval($_GET['devid']);
            $db->exec("UPDATE 'Devices' SET TypeId='" . $devtypeid . "', Name='" . $Name . "', RoomId='" . $Roomid . "' WHERE Id='" . $id . "'");
            $db = null;
            if (REDIRECTS) {
                header('Location: /devices');
            }
            echo "success";
        }
    } elseif ($table == "sensors") {
        if ($action == "new") {
            $rawid = $_GET['devid']; // get the raw device id (MAC/ID)
            list($macId, $controlId) = explode("/", $rawid); // split it into the correct parameters.
            $controlIdType = intval($_GET['controlTypeId']); // this tells us where the mapping topic has been stored.
            $sensorName = $_GET['sensorName']; // get the name for the sensor.
            if ($controlIdType == 3) {
                $SRArray = "";
                foreach ($_GET['outputmap'] as $selectedOption)
                    $SRArray = $SRArray . $selectedOption . ";";
                ////this is a  SR Topic not a map topic
                $db->exec("INSERT INTO 'Sensors' ('DevId', 'ControlId', 'SRDevTopic', 'Name') VALUES ('" . $macId . "','" . $controlId . "','" . $SRArray . "','" . $sensorName . "')");
            } else {
                $mapTopic = $_GET['topicMap'];
                $db->exec("INSERT INTO 'Sensors' ('DevId', 'ControlId', 'MapTopic', 'Name') VALUES ('" . $macId . "','" . $controlId . "','" . $mapTopic . "','" . $sensorName . "')");
            }
            $db = null;
            if (REDIRECTS) {
                header('Location: /sensors');
            }
            echo "success";
        } elseif ($action == "delete") {
            $id = $_GET['id'];
            $db->exec("DELETE FROM 'Sensors' where Id = '" . $id . "'");
            $db = null;
            if (REDIRECTS) {
                header('Location: /sensors');
            }
            echo "success";
        } elseif ($action == "edit") {
            $id = $_GET['id'];
            $Name = $_GET['sensorName'];
            $topicType = $_GET['TopicType'];

            if ($topicType == "SR") {
                $SRArray = "";
                foreach ($_GET['outputmap'] as $selectedOption)
                    $SRArray = $SRArray . $selectedOption . ";";
                $db->exec("UPDATE 'Sensors' SET Name='" . $Name . "', SRDevTopic='" . $SRArray . "' WHERE Id='" . $id . "'");
            } else {
                $topicMap = $_GET['topicMap'];
                $db->exec("UPDATE 'Sensors' SET Name='" . $Name . "', MapTopic='" . $topicMap . "' WHERE Id='" . $id . "'");
            }

            $db = null;
            if (REDIRECTS) {
                header('Location: /sensors');
            }
            echo "success";
        }
    } else
        echo "error";
} catch (Exception $ex) {
    echo $ex;
}





