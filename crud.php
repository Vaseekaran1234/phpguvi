<?php
interface Student
{
    public function save();
    public function delete($id);
    public function viewAll();
    public function viewRecord($id);  
}
class StudentDetails implements Student
{
    private $id = 0;
    private $name = "";
    private $mobileno = "";
    private $email = "";
    private $dob;
    private $address = "";
    private $english;
    private $tamil;
    private $php;
    private $imgs = '';
    public $con;

    public function __construct()
    {
        $this->con = mysqli_connect("localhost", "root", "", "validation");
    }

    public function setID($args)
    {
        $this->id = $args;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setName($args)
    {
        if (empty($args))
            return "Enter the your Name";
        else
            $this->name = $args;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setMobileNo($args)
    {
        if (empty($args))
            return "Enter the your Mobile Number";
        else if (!preg_match("/^[0-9]{10}$/", $args))
            return "Enter the valid mobile number";
        else
            $this->mobileno = $args;
    }
    public function getMobileNo()
    {
        return $this->mobileno;
    }
    public function setEmail($args)
    {
        $regexemail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (empty($args))
            return "Enter the your Email";
        else if (!preg_match($regexemail, $args))
            return "Enter the valid Email";
        else
            $this->email = $args;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setDOB($args)
    {
        if (empty($args))
            return "Enter the your Date of Birth";
        else
            $this->dob = $args;
    }
    public function getDOB()
    {
        return $this->dob;
    }
    public function setAddress($args)
    {
        if (empty($args))
            return "Enter the your Address";
        else
            $this->address = $args;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setEnglish($args)
    {
        if (empty($args))
            return "Enter the your English Mark";
        else if(strlen($args)>=3)
            return "Enter the valid English Mark";
        else
            $this->english = $args;
    }
    public function getEnglish()
    {
        return $this->english;
    }
    public function setTamil($args)
    {
        if (empty($args))
            return "Enter the your Tamil Mark";
        else if(strlen($args)>=3)
            return "Enter the valid Tamil Mark";
        else
            $this->tamil = $args;
    }
    public function getTamil()
    {
        return $this->tamil;
    }
    public function setPhp($args)
    {
        if (empty($args))
            return "Enter the your PHP Mark";
        else if(strlen($args)>=3)
            return "Enter the valid PHP Mark";
        else
            $this->php = $args;
    }
    public function getPHP()
    {
        return $this->php;
    }
    public function setImage($img)
    {
        $profileImage = $img;
        if ($profileImage) {
            $imagePath = "images/" . $profileImage;
            $this->imgs = '<img style="height: 100px; width: 100px;" src="' . $imagePath . '" alt="Profile Image" />';
        }
    }
    public function getImage()
    {
        return $this->imgs;
    }

    public function save()
    {
        $profileImage = $_FILES['profileImage']['name'];
        $profileImage_tmp = $_FILES['profileImage']['tmp_name'];

        move_uploaded_file($profileImage_tmp, "images/" . $profileImage);
        if ($this->id == 0) {
            if (mysqli_num_rows(mysqli_query($this->con, "SELECT * FROM student_details WHERE email='$this->email'")) > 0)
                return 'Dupilcate record is present';
            else 
                if (mysqli_query($this->con, mysqli_query($this->con, "INSERT INTO student_details(id,name,email,mobileno,dob,english,tamil,php,address,profileImage) VALUES('','$this->name','$this->email','$this->mobileno','$this->dob','$this->english','$this->tamil','$this->php','$this->address','$profileImage')")) === true)
                return 'Record inserted successfully';
            else
                return mysqli_error($this->con);
        } else {
            $exisRec = mysqli_query($this->con, "SELECT id, name, email, mobileno, dob, english, tamil, php, address, profileImage FROM student_details WHERE id='$this->id'");
            if (mysqli_num_rows($exisRec) > 0) {
                
                $update = "UPDATE student_details SET 
                    name='$this->name',
                    email='$this->email',
                    mobileno='$this->mobileno',
                    dob='$this->dob',
                    english='$this->english',
                    tamil='$this->tamil',
                    php='$this->php',
                    address='$this->address',
                    profileImage='$profileImage'
                    WHERE id='$this->id'";

                if (mysqli_query($this->con, $update) === true) {
                    header("location:index.php");
                    return 'Record updated successfully';
                } else {
                    return mysqli_error($this->con);
                }
            } else {
                return 'Record does not exist';
            }
        }
    }

    public function delete($id)
    {
        if (mysqli_query($this->con, "DELETE FROM student_details WHERE id='$id'")) {
            header("location:index.php");
        } else {
            echo "<script>alert('Error: {$this->con->error}');</script>";
        }
    }
    public function viewAll()
    {
        $query = "SELECT * FROM student_details";
        $result = mysqli_query($this->con, $query);
        return $result;
    } 

    public function viewRecord($id)
    {
        $query = "SELECT * FROM student_details WHERE id=$id";
        $result = mysqli_query($this->con, $query);
        $stu = new StudentDetails();
        $num_of_rows = mysqli_num_rows($result);
        if ($num_of_rows > 0) {
            $row = mysqli_fetch_array($result);
            $stu->setName($row["name"]);
            $stu->setID($row["id"]);
            $stu->setEmail($row["email"]);
            $stu->setDOB($row["dob"]);
            $stu->setMobileNo($row["mobileno"]);
            $stu->setAddress($row["address"]);
            $stu->setEnglish($row["english"]);
            $stu->setTamil($row["tamil"]);
            $stu->setPhp($row["php"]);
            $stu->setImage($row['profileImage']);
        }
        return $stu;
    }
}
