<style>
    .navbar {
        overflow: hidden;
        background-color: #333;
    }

    .navbar a {
        float: left;
        font-size: 16px;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .dropdown {
        float: left;
        overflow: hidden;
    }

    .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }


    .form {
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 5px;
        margin: 10px auto;
        max-width: 275px;
        height: calc(100% - 100px);
    }

    input {
        height: 40px;
        padding: 5px 10px;
    }

    
</style>

<?php
define('URL', 'http://localhost:8080/super_market/super_market/', true);
?>
<div>
    <div class="navbar">
        <a href="<?php echo URL; ?>index.php">super market</a>
        <div class="dropdown">
            <button class="dropbtn">Product</button>
            <div class="dropdown-content">
                <a href="<?php echo URL; ?>product/create_product.php?new=true">Create Product</a>
                <a href="<?php echo URL; ?>product/get_All_product.php">Get Product</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Suppliers</button>
            <div class="dropdown-content">
                <a href="<?php echo URL; ?>supplier/create_supplier.php?new=true">Create Suppliers</a>
                <a href="<?php echo URL; ?>supplier/get_All_supplier.php">Get Suppliers</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Recipt</button>
            <div class="dropdown-content">
                <a href="<?php echo URL; ?>recipt/new_sale_recipt.php?new=true">Create Sale Recipt</a>
                <a href="<?php echo URL; ?>recipt/new_purchase_recipt.php?new=true">Create Purchase Recipt</a>
                <a href="<?php echo URL; ?>recipt/get_sale_recipt.php">Get Sale Recipt</a>
                <a href="<?php echo URL; ?>recipt/get_purchase_recipt.php">Get Purchase Recipt</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Out come</button>
            <div class="dropdown-content">

                <a href="<?php echo URL; ?>outcom/get_All_out_com.php">Get Out come</a>
            </div>
        </div>
    </div>
</div>