var allUsers = <?php echo json_encode($allUsers); ?>;

$('#friendSearchButton').click(function(){
    var searchValue = $('#friendSearch').val();
    var newHtml = [];
    for(var i = 0;i<allUsers.length;i++){
        if(searchValue.toLowerCase().indexOf((allUsers[i]['name']).toLowerCase()) >= 0){
            newHtml.push('<h4 id="user-'+allUsers[i]+'">'+allUsers[i]['name'] + ' - <a href="friendAdd/'+allUsers[i]['id']+'"> Add</a></h4>');
        }
    }
    if(newHtml.length >0){
        $(".users").html(newHtml.join(""));
    }else{
        $(".users").html("No User with that nickname");
    }


});

function doSomething() {
    window.location = "../myLogout";
}

window.onload = function () {
    setTimeout(doSomething, 3.6e+6); //Then set it to run again after ten minutes
};






/*function refresh_div() {
 jQuery.ajax({
 url:'/countQueue',
 type:'GET',
 success:function(results) {
 jQuery("#QueueCounter").html(results);
 }
 });
 }

 t = setInterval(refresh_div,1000);
 */
