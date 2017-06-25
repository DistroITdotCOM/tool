<?php
require '../inc/config.php';
if (!isset($_COOKIE['user'])) {
    header("Location: " . BASE_URL);
    die();
}
include VIEW_HEADER
?>
<div data-role="page">
    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        $(function () {
            $('input[name=sample]').keyup(function () {
                $('#price').val('Rp ' + numberWithCommas($('#sample').val() * 1010000) + ',00');
                $('input[name=price]').val($('#sample').val() * 1010000);
                $('#duration').val((Math.round($('#sample').val() / 2)) + ' ' + ((Math.round($('#sample').val() / 2) === 1) ? 'day' : 'days'));
                $('input[name=duration]').val(Math.round($('#sample').val() / 2));
            });
            $('#hidden-province').hide();
            $('form input').on('change', function () {
                if ($('input[name=onsite]:checked', 'form').val() === 'no') {
                    $('#hidden-province').hide();
                } else {
                    $('#hidden-province').show();
                }
            });
            $('form').validate({
                rules: {
                    sample: {
                        required: true
                    },
                    start: {
                        required: true
                    }
                },
                messages: {
                    sample: {
                        required: "Please enter your sample job."
                    },
                    start: {
                        required: "Please enter start date job."
                    }
                },
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent().prev());
                },
                submitHandler: function (form) {
                    $.mobile.loading('show', {text: "Please wait...", textonly: false, textVisible: true});
                    var strData = $(form).serialize();
                    $.ajax({
                        type: "POST",
                        url: site + "invoice/minilab53.php",
                        data: strData,
                        dataType: "json",
                        success: function (msg) {
                            if (JSON.parse(msg['success']) === 1) {
                                $.mobile.loading('hide');
                                window.location = site + 'checkout.php';
                            } else {
                                $.mobile.loading('hide');
                                window.location = site + 'index.php?notify=error';
                            }
                        }
                    });
                }
            });
        });
    </script>
    <?php
    $title = "MiniLab 53";
    include VIEW_HEADER_PAGE
    ?>
    <div data-role="main" class="ui-content">
        <form method="post">
            <input type="hidden" name="ajax" value="1">
            <input type="hidden" name="tool_id" value="1">
            <input type="hidden" name="customer_id" value="<?= $_COOKIE['user'] ?>">
            <label for="sample">Sample</label>
            <input type="number" data-clear-btn="true" name="sample" id="sample">
            <label for="price">Price</label>
            <input type="text" data-clear-btn="true" id="price" disabled="yes">
            <input type="hidden" name="price">
            <label for="duration">Duration</label>
            <input type="text" data-clear-btn="true" id="duration" disabled="yes">
            <input type="hidden" name="duration">
            <label for="start">Start</label>
            <input type="date" data-clear-btn="true" name="start" id="start">
            <fieldset data-role="controlgroup" data-type="horizontal">
                <legend>On Site</legend>
                <input type="radio" name="onsite" id="yes" value="yes">
                <label for="yes">Yes</label>
                <input type="radio" name="onsite" id="no" value="no" checked="checked">
                <label for="no">No</label>
            </fieldset>
            <div id="hidden-province">
                <label for="province">Province</label>
                <select name="province" id="province">
                    <option value="Aceh">Aceh</option>
                    <option value="Bali">Bali</option>
                    <option value="Banten">Banten</option>
                    <option value="Bengkulu">Bengkulu</option>
                    <option value="Gorontalo">Gorontalo</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Jambi">Jambi</option>
                    <option value="Jawa Barat">Jawa Barat</option>
                    <option value="Jawa Tengah">Jawa Tengah</option>
                    <option value="Jawa Timur">Jawa Timur</option>
                    <option value="Kalimantan Barat">Kalimantan Barat</option>
                    <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                    <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                    <option value="Kalimantan Timur">Kalimantan Timur</option>
                    <option value="Kalimantan Utara">Kalimantan Utara</option>
                    <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                    <option value="Kepulauan Riau">Kepulauan Riau</option>
                    <option value="Lampung">Lampung</option>
                    <option value="Maluku">Maluku</option>
                    <option value="Maluku Utara">Maluku Utara</option>
                    <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                    <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                    <option value="Papua">Papua</option>
                    <option value="Papua Barat">Papua Barat</option>
                    <option value="Riau">Riau</option>
                    <option value="Sulawesi Barat">Sulawesi Barat</option>
                    <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                    <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                    <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                    <option value="Sulawesi Utara">Sulawesi Utara</option>
                    <option value="Sumatera Barat">Sumatera Barat</option>
                    <option value="Sumatera Selatan">Sumatera Selatan</option>
                    <option value="Sumatera Utara">Sumatera Utara</option>
                    <option value="Yogyakarta">Yogyakarta</option>
                </select>
            </div>
            <button class="ui-shadow ui-btn ui-corner-all">Checkout</button>
        </form>
    </div>
    <?php include VIEW_COPYRIGHT ?>
</div>
<?php include VIEW_FOOTER ?>
