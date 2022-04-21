<?php include_once("header.php"); ?>



<div class="col-sm-9">
<h1 class="text-center">CRUD Generator For spring boot project</h1>


    <div class="col-sm-6">
        <form action="lr_submit.php" method="post">
            <div class="form-group">
                <label for="">Author Name</label>
                <input type="text" class="form-control" name="author_name" required placeholder="Enter Author Name">
                <small id="author_name" class="form-text text-muted">For java and api documentation</small>
            </div>

            <div class="form-group">
                <label for="">Package</label>
                <input type="text" class="form-control" name="package" required  placeholder="com.synesis.mofl.acl">
                <small id="package" class="form-text text-muted">For spring project folder structure</small>
            </div>

            <div class="form-group">
                <label for="">Database Query</label>
                <textarea  class="form-control" name="query" rows="10" cols="50" required ></textarea>
                <small id="query" class="form-text text-muted">Create table query</small>
            </div>




            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="col-sm-4 col-sm-offset-1" style="margin-top: 155px;">

        <div class="row">
            <h3 >Sample Query</h3>
            <pre>
create table user_profiles
(
    id int(11) not null,
    name varchar(50) not null,
    description text ,
    email varchar(50) unique not null,
    phone varchar(50),
    age int(2),
    joining_date date,
    dob datetime
)

            </pre>
        </div>


    </div>



</div>
</div>
</div>


<?php include_once("footer.php"); ?>
