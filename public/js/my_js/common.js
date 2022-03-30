// Reset Form values function
function resetFormValues() {
    // Reset values

    $('#txtApprovingID').val('');
    $('#txtPreshipmentId').val('');
    $('#txtApprovingPackingListControlNo').val('');
    $('#txtApprovingDate').val('');
    $('#txtApproveShipDate').val('');
    $('#txtApprovingStation').val('');
    $('#txtApprovingDestination').val('');
    $('#txtApprovingCheckBy').val('');
    $('#txtApprovingInvoinceNo').val('');

}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalViewWhsePreshipmentForUpload").on('hidden.bs.modal', function () {
    console.log('modal is closed');
    resetFormValues();
});