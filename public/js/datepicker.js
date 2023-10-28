$(function()
{
    const picker = document.getElementById('datepicker');
    picker.min = new Date().toISOString().split("T")[0];

    $("#datepicker").datepicker({

        showOn: "focus",
        startDate: new Date(),
        defaultDate: new Date(),
        format : 'dd/mm/yyyy',

    }).on("changeDate", function (e) {
        $(this).datepicker('hide');
    });



    picker.addEventListener('change', function (e) {
        var day = new Date(this.value).getUTCDay();


        alert(day);
        var pick_day = new Date(this.value).toISOString().split("T")[0];
        if (picker.min == pick_day) {
            Command: toastr["info"]("Pickup on same day is subject to an additional fee of €80");
        }
        if ([6, 0].includes(day)) {
            e.preventDefault();
            Command: toastr["info"]("Pickup on weekend days is subject to an additional fee of €110");
        }
    });
}
)
