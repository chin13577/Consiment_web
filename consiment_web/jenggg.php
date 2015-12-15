
down vote
You don't need javascript for doing so. Just delete the onClick and write the php Admin.php file like this:

<!-- HTML STARTS-->
<?php
//If all the required fields are filled
if (!empty($GET_['fullname'])&&!empty($GET_['email'])&&!empty($GET_['name']))
{
function addNewContact()
    {
    $new = '{';
    $new .= '"fullname":"' . $_GET['fullname'] . '",';
    $new .= '"email":"' . $_GET['email'] . '",';
    $new .= '"phone":"' . $_GET['phone'] . '",';
    $new .= '}';
    return $new;
    }

function saveContact()
    {
    $datafile = fopen ("data/data.json", "a+");
    if(!$datafile){
        echo "<script>alert('Data not existed!')</script>";
        } 
    else{
        $contact_list = $contact_list . addNewContact();
        file_put_contents("data/data.json", $contact_list);
        }
    fclose($datafile);
    }

// Call the function saveContact()
saveContact();
echo "Thank you for joining us";
}
else //If the form is not submited or not all the required fields are filled

{ ?>

<form>
    <fieldset>
        <legend>Add New Contact</legend>
        <input type="text" name="fullname" placeholder="First name and last name" required /> <br />
        <input type="email" name="email" placeholder="etc@company.com" required /> <br />
        <input type="text" name="phone" placeholder="Personal phone number: mobile, home phone etc." required /> <br />
        <input type="submit" name="submit" class="button" value="Add Contact"/>
        <input type="button" name="cancel" class="button" value="Reset" />
    </fieldset>
</form>
<?php }
?>