/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//live search for selects - npm-modules
require('../../node_modules/bootstrap-select/dist/js/bootstrap-select.min');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


/**
 *  SIDEBAR   
 */
// Hide submenus
$('#body-row .collapse').collapse('hide'); 

// Collapse/Expand icon
$('#collapse-icon').addClass('fa-angle-double-left'); 

// Collapse click
$('[data-toggle=sidebar-colapse]').on('click', function() {
    SidebarCollapse();
});

function SidebarCollapse () {
    $('.menu-collapsed').toggleClass('d-none');
    $('.sidebar-submenu').toggleClass('d-none');
    $('.submenu-icon').toggleClass('d-none');
    $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
    
    // Treating d-flex/d-none on separators with title
    var SeparatorTitle = $('.sidebar-separator-title');
    if ( SeparatorTitle.hasClass('d-flex') ) {
        SeparatorTitle.removeClass('d-flex');
    } else {
        SeparatorTitle.addClass('d-flex');
    }
    
    // Collapse/Expand icon
    $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
}



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
    <tr class="d-flex" id="R${rowIdx}">
        <td class="col-4">
            <select class="form-control product" data-live-search="true"  name="product[]">
            
            </select>
        </td>

        <td class="col-2">
            <div class="form-group">
                <input type="float" class="form-control price" value="0" name="price[]" readonly>
            </div>
        </td>

        <td class="col-2">
            <div class="form-group">
                <input type="number" min="1" step="1" class="form-control amount" value="1" name="amount[]" disabled>
            </div>  
        </td>

        <td class="col-3">
            <div class="form-group">
                <input type="float" class="form-control totalPrice" value="0" name="totalPrice[]" readonly>
            </div>  
        </td>

        <td class="col-1">
            <div class="form-group">
                <a href="#" class="btn btn-danger btn-sm" id="delete_R${rowIdx}"><i class="fas fa-trash-alt"></i></a>
            </div>  
        </td>
    </tr>
    `); 

    //add options to product select
    var select = $('#R'+rowIdx).find('.product');
    console.log('#R'+rowIdx);
    
    $('#selOptions option').each(function(){
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


//live search for selects
$(function () {
    $('select').filter(":visible").selectpicker();
});

