<?php
class profileoperator
{
    private $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function user_create_profile($id, $name, $mobileno, $address, $state, $pincode, $gender)
    {
        $query = "INSERT INTO profiles(Name,MobileNumber,Address,State,Gender,Pincode,UserID)VALUES(:Name,:MobileNumber,:Address,:State,:Gender,:Pincode,:UserID)";
        try {
            $insertdatatoprofile = $this->db->prepare($query);
            $insertdatatoprofile->bindParam(':Name', $name);
            $insertdatatoprofile->bindParam(':MobileNumber', $mobileno);
            $insertdatatoprofile->bindParam(':Address', $address);
            $insertdatatoprofile->bindParam(':State', $state);
            $insertdatatoprofile->bindParam(':Gender', $gender);
            $insertdatatoprofile->bindParam(':Pincode', $pincode);
            $insertdatatoprofile->bindParam(':UserID', $id);
            if ($insertdatatoprofile->execute()) {
                $success['Success'] = true;
                $success['Messege'] = "Your was Profile Updated";
                return $success;
            } else {
                $success['Success'] = false;
                $success['Messege'] = "Something Went  Wrong";
                return $success;
            }
        } catch (PDOException $e) {
            echo "Not Inserted..." . $e->getMessage();
        }
    }
    public function user_update_profile($logid, $name, $mobileno, $address, $state, $pincode, $gender)
    {
        $query = "UPDATE profiles SET Name='$name',MobileNumber='$mobileno',Address='$address',State='$state',Gender='$gender',Pincode='$pincode' WHERE UserID=$logid";
        try {
            $updateprofile = $this->db->prepare($query);
            if ($updateprofile->execute()) {
                $success['Success'] = true;
                $success['Messege'] = "Your was Profile Updated";
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function get_profile($id)
    {
        $query = "SELECT profiles.ID,profiles.Name,profiles.MobileNumber,profiles.Address,profiles.State,profiles.Gender,profiles.Pincode,users.Email FROM profiles,users WHERE profiles.UserID=users.ID AND users.ID=?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute(array($id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                $success['Success'] = true;
                $success['Profile'] = $result;
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}