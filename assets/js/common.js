$('#registration').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);

    $.ajax({
        type:'POST',
        url: 'config/handler.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
           const errorText = document.querySelectorAll('.form-control-feedback');
           errorText.forEach(function(item) {
                item.textContent = "";
           });
           const formGroup = document.querySelectorAll('.form-group');
           formGroup.forEach(function(item){
                item.classList.remove('has-danger');
           })
           document.querySelector("button").disabled = true;
           document.querySelector("button").textContent = "Загрузка..."
        },
        success: function(response){
            swal({
                title: "Отлично!",
                text: "Пользователь успешно зарегистрирован!",
                icon: "success",
            }).then(() => {
                location.reload();
            });
            document.querySelector("button").disabled = false;
            document.querySelector("button").textContent = "Зарегистрироваться";
        },
        error: function(response){            
           var errors = response.responseJSON;
           if (errors.errors) {
               errors.errors.forEach(function(data, index) {
                   var field = Object.getOwnPropertyNames (data);
                   var value = data[field];
                   var div = $("#"+field[0]).closest('div');
                   div.addClass('has-danger');
                   div.children('.form-control-feedback').text(value);
               });
           }

           document.querySelector("button").disabled = false;
           document.querySelector("button").textContent = "Зарегистрироваться";

        }
    });
});

function deleteComment(id) {
    $.ajax({
            type:'POST',
            url: '/config/delete_comment.php',
            data: "id="+id, 
            success: function(response){
                location.reload();
            },
            error: function(response){  
            }
    });
}

function deletePhoto(id) {
    $.ajax({
            type:'POST',
            url: '/config/delete_photo.php',
            data: "id="+id, 
            success: function(response){
                location.href = '/login';
            },
            error: function(response){  

            }
    });
}

function logout() {
    console.log('logout');
    $.ajax({
            type:'POST',
            url: '/config/logout.php',
            success: function(response){
                location.href = '/';
            },
            error: function(response){  

            }
    });
}

$('#addComment').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type:'POST',
        url: 'config/add_comment.php',
        data: data,
        success: function(response){
            location.href = '/photo';
        },
        error: function(response){  

        }    
    });
});