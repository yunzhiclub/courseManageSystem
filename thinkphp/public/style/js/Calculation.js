/**
 * @authors zhuchenshu
 * @date    2017-09-13 16:47:11
 */
// 计算价格
function jisuan() {
    var adult_num = document.getElementById("adultNum").value;
    var child_num = document.getElementById("childNum").value;

    // 获取机票单价
    var plane_adult_unit_price = document.getElementById('planeAdultUnitPrice').value;
    var plane_child_unit_price = document.getElementById('planeChildUnitPrice').value;

    // 计算总价
    var plane_total_price = parseFloat(adult_num) * parseFloat(plane_adult_unit_price) + parseFloat(child_num) * parseFloat(plane_child_unit_price);

    // 判断是否由传入的数据为空
    if (isNaN(plane_total_price)) {
        document.getElementById("planeTotalPrice").value = 0;
    } else {
        document.getElementById("planeTotalPrice").value = plane_total_price;
    }

    // 获取签证单价
    var visa_adult_unit_price = document.getElementById("visaAdultUnitPrice").value;
    var visa_child_unit_price = document.getElementById("visaChildUnitPrice").value;

    // 计算总价
    var visa_total_price = parseFloat(adult_num) * parseFloat(visa_adult_unit_price) + parseFloat(child_num) * parseFloat(visa_child_unit_price);

    // 判断是否由传入的数据为空
    if (isNaN(visa_total_price)) {
        document.getElementById("visaTotalPrice").value = 0;
    } else {
        document.getElementById("visaTotalPrice").value = visa_total_price;
    }

    // 获取旅游单价
    var tourism_adult_unit_price = document.getElementById('tourismAdultUnitPrice').value;
    var tourism_child_unit_price = document.getElementById('tourismChildUnitPrice').value;

    // 计算总价
    var tourism_total_price = parseFloat(adult_num) * parseFloat(tourism_adult_unit_price) + parseFloat(child_num) * parseFloat(tourism_child_unit_price);

    // 判断是否由传入的数据为空
    if (isNaN(tourism_total_price)) {
        document.getElementById("tourismTotalPrice").value = 0;
    } else {
        document.getElementById("tourismTotalPrice").value = tourism_total_price;
    }

    // 获取保险单价
    var insurance_adult_unit_price = document.getElementById('insuranceAdultUnitPrice').value;
    var insurance_child_unit_price = document.getElementById('insuranceChildUnitPrice').value;

    // 计算总价
    var insurance_total_price = parseFloat(adult_num) * parseFloat(insurance_adult_unit_price) + parseFloat(child_num) * parseFloat(insurance_child_unit_price);

    // 判断是否由传入的数据为空
    if (isNaN(insurance_total_price)) {
        document.getElementById("insuranceTotalPrice").value = 0;
    } else {
        document.getElementById("insuranceTotalPrice").value = insurance_total_price;
    }

    // 计算总费用
    document.getElementById('totalCost').value = plane_total_price + visa_total_price + tourism_total_price + insurance_total_price;
}