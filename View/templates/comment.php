<div class="row">
    <div class="col-lg-2 text-left">
        <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar " alt="user profile image">
    </div>
    <div class="col-lg-2 text-left">
        <h5><a href="/?action=user&id=<?= $userId ?>"><b><?= $userFullName?></b></a></h5>
        <h6 class="text-muted time"><?= $commentDate?></h6>
    </div>
    <div class="col-lg-8 text-justify"> 
        <p><?= $commentContent ?></p>
    </div>
</div>
<hr>
