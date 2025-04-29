
jQuery.noConflict();
jQuery(function($){
	$('#pdfListArea .thum a').on('click', function(e){
        e.preventDefault();
        const $target = $(this).closest('.box');
        const src = $target.find('.boxThum img').attr('src');
        const lastUpdate = $target.find('.boxDate span').html();
        const newFlag = !!$target.find('.boxDate .new').length;
        const title = $target.find('.boxTtl h3').html();
        const type = $target.find('.category p').html();
        const sizePage = $target.find('.size p').html();
        const fileName = $target.data('pdf');
        const dealerFields = !!$target.find('.store').length;
        const href = $target.find('.btnDl a').attr('href');
        const pdfId = $(this).attr('id');
        const comment = $target.find('.comment').html();
    
        $('#pdfWinThumbnail').attr('src', src);
        $('#pdfWinLastUpdate').html(lastUpdate);
        if (newFlag) {
          $('#pdfWinNew').show();
        }else{
          $('#pdfWinNew').hide();
        }
        $('#pdfWinTitle').html(title);
        $('#pdfWinType').html(type);
        $('#pdfWinSizePage').html(sizePage);
        $('#pdfWinFileName').html(fileName);
        if (dealerFields) {
          $('#pdfWinDealerFields').show();
        }else{
          $('#pdfWinDealerFields').hide();
        }
        $('.pdfWinPdfDownload').attr('href', href);
        $('.pdfWinPdfDownload').data('pdf_id', pdfId);
    
        $('#pdfWinComment').html(comment);
        $('#pdfWinId').fadeIn();
            $('#pdfWinOver').fadeIn();
    
        $('.btnCopyURL').data('id', pdfId);
    
        $('#pdfWinId .pdfWinInnerContents').focus();
    
            return false;
        });
        $('#pdfWinOver,.pdfWinClose').on('click', function(e){
        e.preventDefault();
            $('#pdfWinId').fadeOut();
            $('#pdfWinOver').fadeOut();
    
        var QueryParams = removeQueryParam('win');
        if (QueryParams === '') {
          history.pushState("", document.title, window.location.pathname );
        }else{
          history.pushState("", document.title, window.location.pathname + '?' + QueryParams);
        }
            return false;
        });
    
        if('none' !== $('#pdfWinId').css('display')){
            $('#pdfWinId .pdfWinInnerContents').focus();
        }
});



