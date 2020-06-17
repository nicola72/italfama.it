function show_others(url)
{
    $('#product_list').fadeOut();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "html",
        success: function (data)
        {
            $('#product_list').html(data);
            window.scrollTo(0, 0);
            $('#product_list').fadeIn();

        },
        error: function ()
        {
            alert("Si è verificato un errore! Riprova!");
        }
    });
}

function ordina(value)
{
    $('#order').val(value);
    $('#form_ordinamento').submit();
}

function filtra(value)
{
    $('#filter').val(value);
    $('#form_filtro').submit();
}

function addToCart(url) {

    $.ajax({
        url: url,
        dataType: "json",
        type: "get",
        success: function (data)
        {
            if(data.result === 1)
            {
                alert(data.msg);
                location.reload();
            }
            else
            {
                alert(data.msg);
            }
        }
    });
}

function cartUpdateQta(url,id_carrello) {
    var qta = $("input[name='qta'][data-idrow='" + id_carrello + "']").val();

    $.ajax({
        url: url,
        data: {'id': id_carrello,'qta':qta },
        dataType: "json",
        type: "get",
        success: function (data)
        {
            if(data.result === 1)
            {
                location.reload();
            }
            else
            {
                alert(data.msg);
            }
        }
    });
}