function saveInCart(catalog_id, user){
    if(!user){
        $('#auth').show()
    }
    else{
        $.ajax({
            type: "POST",
            url: "api/cart.php",
            data: {
                catalog_id,
                user
            },
            success: function(data){
                if(JSON.parse(data)){
                    window.location.reload()
                }
            }
        })
    }
}

function deleteAllCarts(user){
    $.ajax({
        type: "POST",
        url: "api/deleteCarts.php",
        data: {
            user
        },
        success: function(data){
            if(JSON.parse(data)){
                window.location.reload()
            }
        }
    })
}

function deleteOneCart(id){
    $.ajax({
        type: "POST",
        url: "api/deleteOneCart.php",
        data: {
            id
        },
        success: function(data){
            if(JSON.parse(data)){
                window.location.reload()
            }
        }
    })
}