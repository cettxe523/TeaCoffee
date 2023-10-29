function btnMinus(id, user){
    let count = document.getElementById(`counter-${id}`)
    let result = document.getElementById(`result-${id}`)
    let price = document.getElementById(`price-${id}`)
    let finalPrice = document.getElementById('finalPrice')
    
    if(Number(count.textContent) > 1){
        count.textContent = Number(count.textContent) - 1
        result.textContent = Number(count.textContent) * price.textContent.split(' ')[0] + ' ₽'

        $.ajax({
            type: "POST",
            url: "api/cartCount.php",
            data: {
                count: count.textContent,
                id
            },
            success: function(data){
                console.log(JSON.parse(data))
            }
        })

        $.ajax({
            type: "POST",
            url: "api/getSumCarts.php",
            data: {
                count: count.textContent,
                user
            },
            success: function(data){
                console.log(JSON.parse(data))
                finalPrice.textContent = "Итог: " + JSON.parse(data) + " ₽"
            }
        })
    }
}

function btnPlus(id, user){
    let count = document.getElementById(`counter-${id}`)
    let result = document.getElementById(`result-${id}`)
    let price = document.getElementById(`price-${id}`)
    let finalPrice = document.getElementById('finalPrice')

    count.textContent = Number(count.textContent) + 1
    result.textContent = Number(count.textContent) * price.textContent.split(' ')[0] + ' ₽'
    

    $.ajax({
        type: "POST",
        url: "api/cartCount.php",
        data: {
            count: count.textContent,
            id
        },
        success: function(data){
            console.log(JSON.parse(data))
        }
    })

    $.ajax({
        type: "POST",
        url: "api/getSumCarts.php",
        data: {
            user
        },
        success: function(data){
            console.log(JSON.parse(data))
            finalPrice.textContent = "Итог: " + JSON.parse(data) + " ₽"
        }
    })
}