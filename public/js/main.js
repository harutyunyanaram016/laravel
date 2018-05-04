$( document ).ready(function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(".remove-user").click(function () {
        var id = $(this).parent().parent().children().eq(0).text();

        $.post('/admin/remove-user', {id:id,_token:CSRF_TOKEN},function (data) {
            console.log(data);
        })
    })


    function get_elapsed_time_string(total_seconds) {
        function pretty_time_string(num) {
            return ( num < 10 ? "0" : "" ) + num;
        }
        var hours = Math.floor(total_seconds / 3600);
        total_seconds = total_seconds % 3600;

        var minutes = Math.floor(total_seconds / 60);
        total_seconds = total_seconds % 60;

        var seconds = Math.floor(total_seconds);

        // Pad the minutes and seconds with leading zeros, if required
        hours = pretty_time_string(hours);
        minutes = pretty_time_string(minutes);
        seconds = pretty_time_string(seconds);

        // Compose the string for display
        var currentTimeString = hours + ":" + minutes + ":" + seconds;

        return currentTimeString;
    }


    var timer1 = '';
    var timer = function(){
        timer1 = setInterval(function() {
            elapsed_seconds = elapsed_seconds + 1;
            $('.Timer').text(get_elapsed_time_string(elapsed_seconds));
        }, 1000);
    };

    $("#start").click(function(){
        $("#stop").attr('disabled',false)
        var self = $(this);
        if($(this).text() == ' Start '){
            $.post('/get-timer', {user_id:userId,_token:CSRF_TOKEN,status:'start',time:elapsed_seconds}, function (date) {
                var data = JSON.parse(date);
                if(data) {
                    console.log(100);
                    timer();
                    self.text(' Pause ');
                }
            })
            
        }else{
            // console.log(elapsed_seconds);
            $.post('/get-timer', {user_id:userId,_token:CSRF_TOKEN,status:'pause',time:elapsed_seconds}, function (date) {
                var data = JSON.parse(date);
                if(data) {
                    console.log(100);
                    self.text(' Start ');
                    clearInterval(timer1);
                }
            })

        }
    })

    $("#stop").click(function(){
        $.post('/get-timer', {user_id:userId,_token:CSRF_TOKEN,status:'stop',time:elapsed_seconds}, function (date) {
            var data = JSON.parse(date);
            if(data) {
                $("#stop").attr('disabled', true);
                $("#start").attr('disabled', true);
                clearInterval(timer1);
            }
        })
    })
    if(status == 'start'){
        timer();
    }
    $("#add-project").click(function () {
        var start = $("#project-start").val();
        var end = $("#project-end").val();
        var name = $("#project-name").val();
        if(!start || !end || !name){
            alert('Fill in all filds');
            return;
        }
        $.post('/admin/add-project', {_token:CSRF_TOKEN,name:name,end:end,start:start}, function (date) {
            var data = JSON.parse(date);
            if(date){
                window.location.href =  '/admin'
            }
        })
    })

    $(".user-project").change(function(){
        var user = $(this).val();
        var project = $(this).parent().parent().attr('data-id');
        var usPj = 0
        if($(this).parent().parent().attr('data-us')){
            usPj = $(this).parent().parent().attr('data-us');
        }
        $.post('/admin/project-user', {_token:CSRF_TOKEN,user:user,project:project,usPj:usPj}, function (date) {
            var data = JSON.parse(date);
            if(date){
                window.location.href =  '/admin'
            }
        })
    })

    $(".remove-project").click(function () {
        var id = $(this).parent().parent().attr('data-id');
        $.post('/admin/project-remove', {_token:CSRF_TOKEN,id:id}, function (date) {
            var data = JSON.parse(date);
            if(date){
                window.location.href =  '/admin'
            }
        })
    })
    $(".edit-project").click(function () {
        var parent = $(this).parent().parent()
        var id = parent.attr('data-id');
        var start = parent.children().eq(2).text();
        var end =parent.children().eq(3).text();
        var name = parent.children().eq(1).text();
        $.post('/admin/project-edit', {_token:CSRF_TOKEN,id:id,name:name,end:end,start:start}, function (date) {
            var data = JSON.parse(date);
            if(date){
                window.location.href =  '/admin'
            }
        })
    })
});