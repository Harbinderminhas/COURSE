<?php
include_once ("headerfiles.html");
include_once ("courseheader.html");
@session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HOME</title>
</head>

<h1>Welcome <?php echo $_SESSION["name"]  ?></h1>

<script>

    function deletePreference(obj) {
        var prefid=obj["prefid"];
        alert(prefid);
        var formdata=new FormData();
        formdata.append("prefid",prefid);
        formdata.append("deletePreference","deletePreference");
        var httpreg=new XMLHttpRequest();
        httpreg.open("POST","courseAction.php",true);
        httpreg.send(formdata);
        httpreg.onreadystatechange=function () {
            if(this.readyState==4 && this.status==200)
            {
                var response="";
                if(this.response==3)
                {
                    displayPreference();
                }
                else
                {
                    response="<h1>Failure</h1>"
                }

            }


        }

    }



    function editPreference(obj) {


        $('#editPref').modal('show');



    }
    function displayPreference()
    {

        var formdata=new FormData();
        formdata.append("getPreference","getPreference");
        var httpreg=new XMLHttpRequest();
        httpreg.open("POST","courseAction.php",true);
        httpreg.send(formdata);
        httpreg.onreadystatechange=function () {

            if(this.readyState==4 && this.status==200)
            {
                var data=JSON.parse(this.response);
                var tab="";
                var row=0;


                for(var i in data)
                {   tab+="<tr>";
                    tab+="<td>"+ (++row)+"</td>";

                    tab+="<td>"+data[i]["college"]+"</td>";
                    tab+="<td>"+data[i]["course"]+"</td>";

                    tab+="<td><span class='fa fa-edit' style='cursor: pointer' onclick='editPreference("+JSON.stringify(data[i])+")'> </span> </td>";
                    tab+="<td><span class='fa fa-trash' style='cursor: pointer' onclick='deletePreference("+JSON.stringify(data[i])+")'> </span> </td>";

                    tab+="</tr>";
                }


                document.getElementById("prefBody").innerHTML=tab;
            }
        }

    }

    $(document).ready(function () {
        displayPreference();
    });

    function preferenceFun() {

        if($("#selectCourse").valid())
        {
            var controls=document.getElementById("selectCourse").elements;
            var formdata=new FormData();
            for(var i=0;i<controls.length;i++)
            {
                formdata.append(controls[i].name,controls[i].value);
                console.log(controls[i].name,controls[i].value);

            }

            var response="";
            var httpreg=new XMLHttpRequest();
            httpreg.open("POST","courseAction.php",true);
            httpreg.send(formdata);
            httpreg.onreadystatechange=function () {
                if(this.readyState==4 && this.status==200)
                {
                    if(this.response==1)
                    {
                        response="<h1 class='text-danger'>DATA INSERTED</h1>"
                        displayPreference();
                    }
                    else if(this.response==2)
                    {
                        response="<h1 class='text-danger'>FAILURE</h1>"

                    }
                    else
                    {
                        response="<h1 class='text-danger'>GOD KNOWS</h1>"

                    }


                    document.getElementById("output").innerHTML=response;

                }

            }


        }


    }
</script>






<body>
<div class="container">
    <form id="selectCourse" class="selectCourse">
    <div class="form-group">
    <h1 class="text-danger">COURSE ASSIGNMENT</h1>
    <label for="college" class="text-dark font-weight-bold">SELECT COLLEGE</label>
    <select id="college" name="college" class="form-control" data-rule-required="true">
        <option value="">Select College</option>
    <?php
    for($i=1;$i<=70;$i++)
    {
     ?>
    <option value="college <?php echo $i ?>" name="college<?php echo $i ?>">College <?php echo $i ?></option>
    <?php
    }

    ?>
    </select>
    </div>

    <div class="form-group">

    <label for="course" class="text-dark font-weight-bold">SELECT COURSE</label>
    <select id="course"  name="course" class="form-control" data-rule-required="true">
        <option value="">Select Course</option>
        <?php
        for($i=1;$i<=20;$i++)
        {
            ?>
            <option name="course <?php echo $i ?>"  value="course<?php echo $i ?>">Course <?php echo $i ?></option>
            <?php
        }

        ?>
    </select>

</div>

        <button type="button" class="btn btn-danger" name="preferenceSelection" onclick="preferenceFun()" >Preference Selection</button>

    </form>
</div>


<div id="output"></div>

<!------------------DISPLAY PREFERENCES------------->
<table class="table table-striped">
    <thead>
    <th>Preference</th>
    <th>COURSE</th>
    <th>College</th>
    <th>Controls</th>


    </thead>
    <tbody id="prefBody">


    </tbody>

</table>
<!------------------DISPLAY PREFERENCES ENDS------------->

<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="editPref" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">

                <div class="container">
                <form id="selectEditCourse" class="selectEditCourse">
                        <div class="form-group">
                            <h1 class="text-danger">COURSE ASSIGNMENT</h1>
                            <label for="editcollege" class="text-dark font-weight-bold">SELECT COLLEGE</label>
                            <select id="editcollege" name="editcollege" class="form-control" data-rule-required="true">
                                <option value="">Select College</option>
                                <?php
                                for($i=1;$i<=70;$i++)
                                {
                                    ?>
                                    <option name="college<?php echo $i ?>">College <?php echo $i ?></option>
                                    <?php
                                }

                                ?>
                            </select>
                        </div>

                        <div class="form-group">

                            <label for="editcourse" class="text-dark font-weight-bold">SELECT COURSE</label>
                            <select id="editcourse"  name="course" class="form-control" data-rule-required="true">
                                <option value="">Select Course</option>
                                <?php
                                for($i=1;$i<=20;$i++)
                                {
                                    ?>
                                    <option name="course<?php echo $i ?>">Course <?php echo $i ?></option>
                                    <?php
                                }


                                ?>
                            </select>

                        </div>

                        <button type="button" class="btn btn-danger" name="editpreferenceSelection" onclick="preferenceFun()" >Preference Selection</button>

                    </form>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>











</body>
</html>
