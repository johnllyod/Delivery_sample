function UseImgLink()
{
    const cBoxImgLink = document.getElementById("CBImgLink");
    const uploadImage = document.getElementById("UploadImage");
    const linkImage = document.getElementById("LinkImage");
    const uploadImageInput = document.getElementById("UploadImageInput");
    const linkImageInput = document.getElementById("LinkImageInput");

    if (cBoxImgLink.checked)
    {
        uploadImage.classList.add("d-none");
        linkImage.classList.remove("d-none");
        uploadImageInput.required = false;
        linkImageInput.required = true;
    }
    else
    {
        uploadImage.classList.remove("d-none");
        linkImage.classList.add("d-none");
        uploadImageInput.required = true;
        linkImageInput.required = false;
    }
}

function OnSale() {
    const sale = document.getElementById("Sale");
    const salePrice = document.getElementById("SalePrice");
    const saleInput = document.getElementById("SaleInput");

    if (sale.checked) {
        salePrice.classList.remove("d-none");
        saleInput.required = true;
    }
    else {
        salePrice.classList.add("d-none");
        saleInput.required = false;
    }
}

function myFunction(id) // warning before deleting a menu item.
{
    var r = confirm("Are you sure you want to delete this record?");
    if (r == true) {
        window.location.assign("delete.php?id=" + id);
    }
}

function ChangeSort() {
    var sortVal = document.getElementById("sort").value;
    if (sortVal == "OrderDate") // change sort dropdown if date is selected.
    {
        document.getElementById("sortD").style.display = "block";
        document.getElementById("sortU").style.display = "none";
        document.getElementById("sortP").style.display = "none";
    }
    else if (sortVal == "User") // change sort dropdown if user is selected.
    {
        document.getElementById("sortD").style.display = "none";
        document.getElementById("sortU").style.display = "block";
        document.getElementById("sortP").style.display = "none";
    }
    else // change sort dropdown if payment method was selected.
    {
        document.getElementById("sortD").style.display = "none";
        document.getElementById("sortU").style.display = "none";
        document.getElementById("sortP").style.display = "block";
    }
}