import '../css/app.scss';

import 'bootstrap';
import $ from 'jquery';

console.log('js');

$('#search_brand').change(event => {
    const $brand = $(event.currentTarget);

    $.ajax({
        url: $brand.attr('data-url-models'),
        type: "GET",
        dataType: "JSON",
        data: {
            brand_id: $brand.val()
        },
        success(models) {
            const $modelSelect = $("#search_model");

            $modelSelect.removeAttr('disabled');
            $modelSelect.html('');
            $modelSelect.append('<option value> Выберите модель ' + $brand.find("option:selected").text() + ' ...</option>');

            $.each(models, (_, model) => {
                $modelSelect.append('<option value="' + model.id + '">' + model.name + '</option>');
            });
        }
    });
});
