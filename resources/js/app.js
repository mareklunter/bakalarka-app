require('./bootstrap');
require('bootstrap-select'); //live search for selects - npm-modules


/**
 * add listener to given row for price refreshing when creting order
 */
function updateOrderPrice() {
    var priceSum = 0;
    $('.totalPrice').toArray().forEach(element => {
        priceSum += parseFloat(element.value);
    });

    $('.priceTag').html(priceSum.toFixed(2));
    $('#orderPrice').val(priceSum.toFixed(2));
}

function updateRowPrices(row) {
    $(row).on('change', function(){
        let selOption = $(row).find('option:selected');
        let amount = $(row).find('.amount').val();

        $(row).find('.price').val(selOption.data('price'));
        $(row).find('.totalPrice').val((selOption.data('price')*amount).toFixed(2));

        updateOrderPrice();
    });
}


/**
 * add listener to given row for enabling 'amount' input when product is choosed
 */
function enableAmount(row) {
    row.find('.product').on('change', function() {
        row.find('.amount').prop( "disabled", false);
    });
}


/**
 * add deleting functionality to given delete link on row[rowIndx]  
 */
function deleteRow(rowIdx) {
    $('#delete_R'+rowIdx).on('click', function(event) {
        event.preventDefault();

        let row = $('#R'+rowIdx);
        row.remove();

        updateOrderPrice();
    });
} 


/**
 * add event listeners to all rows when page is loaded
 */ 
var orderRows = $('tbody').find('tr');

orderRows.each(function(index, value) {
    updateRowPrices($(value));
    enableAmount($(value));
    deleteRow(index);
});


/**
 * ORDER TABLE - add new row to order
 */
var rowIdx = orderRows.toArray().length; //set index to last row + 1
var table = $("#orderTable").find('tbody');

$('#addToOrder').on('click', function(event) {
    event.preventDefault();

    table.append(
    `
    <tr id="R${rowIdx}">
        <td>
            <select class="form-control product"  data-container="#R${rowIdx}" data-size="5" title="-- vyber produkt --" data-live-search="true"  name="product[]">
            
            </select>
        </td>

        <td>
            <div class="form-group">
                <input type="number" step="0.01" min="0" min class="form-control price" value="0" readonly>
            </div>
        </td>

        <td>
            <div class="form-group">
                <input type="number" step="1" min="1" class="form-control amount" value="1" name="amount[]" disabled>
            </div>  
        </td>

        <td>
            <div class="form-group">
                <input type="number" step="0.01" min="0" class="form-control totalPrice" value="0" readonly>
            </div>  
        </td>

        <td>
            <div class="form-group">
                <a href="#" class="btn btn-danger btn-sm" id="delete_R${rowIdx}"><i class="fas fa-trash-alt"></i></a>
            </div>  
        </td>
    </tr>
    `); 

    //add options to product select
    var select = $('#R'+rowIdx).find('.product');
    
    $('#productOpt option').each(function(){
        var option = this;
        select.append(option.outerHTML);
    });

    //add live search to select
    select.selectpicker();
    

    //add event listener for delete button to the new row
    deleteRow(rowIdx);

    
    var row = $('#R'+rowIdx);
    
    //add event listener for price refreshing to the new row
    updateRowPrices(row);

    //add event listener for price refreshing to the new row
    enableAmount(row);

    rowIdx++;
});


//update order price when form submitted
$('#orderForm').on('submit', function(){
    updateOrderPrice();
});

//live search for selects
$(function () {
    $('select').filter(":visible").selectpicker();
});


//charts time period updating
$('#charts-wrapper').on('click', 'a', function(e) {
    if ( this.parentElement.dataset.chart == 'salesChart' ) {
        var editChart = salesChart;
    } else if ( this.parentElement.dataset.chart == 'ordersChart' ) {
        var editChart = ordersChart;
    };
    
    $.ajax({
        url: $(this).attr("href"),
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            editChart.chart.data.labels = data.labels;
            editChart.chart.data.datasets[0].data = data.data;
            editChart.chart.update();
        },
        error: function(data) {
            console.log('ajax error: ' + data);
        }
    });

    let groupButtons = $(this).parent().find('a');
    groupButtons.removeClass('active');
    $(this).addClass('active'); 

    e.preventDefault();
})

//show-hide order details
$('#orderList').on('click', '.orderDetails', function(event) {
    $(this).closest('tr').next().toggle();
    event.preventDefault();
});


$('#showUserPassEdit').on('click', function(event){
    $('#userInfoEdit').hide();
    $('#userPassEdit').show();
    event.preventDefault();
})

$('#showUserInfoEdit').on('click', function(event){
    $('#userInfoEdit').show();
    $('#userPassEdit').hide();
    event.preventDefault();
})


//sidebar - when sidebar is expanded and main content is clicked - hide sidebar
$('.overlay').on('click', function() {
    let overlay = document.querySelector('.overlay');
    let navigation = document.querySelector('.navigation');
    let toggle = document.querySelector('.toggle');
    navigation.classList.remove('active');
    toggle.classList.remove('active');
    overlay.classList.remove('active');
});

