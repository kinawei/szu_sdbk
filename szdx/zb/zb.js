var errTips = ['民族', '政治面貌', '联系电话', '入学前户口所在地', '现户口所在地', '左眼视力', '右眼视力', '身高', '体重', '血压'];

$("input").focus(function () {
	$(this).parent().parent('.form-group').removeClass('has-error');
});

function subForm () {
	$('input').each(function(i){
		isSub = 0;
		value = this.value;
		eleClass = this.id.slice(6);
		if (value == '') {
			showTips('error', '“' + errTips[i] + '”不能为空');
			$(this).parent().parent('.form-group').addClass("has-error");
			return false;
		}
		if (eleClass == 'phone') {
			if (value.length != 11) {
				if (value.length != 6) {
					showTips('error', '“' + errTips[i] + '”输入错误');
					$(this).parent().parent('.form-group').addClass("has-error");
					return false;
				}	
			}
		}
		if (eleClass == 'phone' || eleClass == 'left' || eleClass == 'right' || eleClass == 'height' || eleClass == 'weight' || eleClass == 'bpre') {
			if (isNaN(parseInt(Number(value)))) {
				showTips('error', '“' + errTips[i] + '”输入错误1');
				$(this).parent().parent('.form-group').addClass("has-error");
				return false;
			}
		}
		isSub = 1;
	});
	if (isSub) {
		$('.form-horizontal').submit();
	}
}

function showTips (tipsType, tipsContents) {
	var tipsClass;
	switch (tipsType) {
		case "error":
			tipsClass = "errortip";
			break;
		case "success":
			tipsClass = "successtip";
			break;
		default:
			tipsClass = "errortip";
			break;
	}
	$(".showtips").addClass(tipsClass).text(tipsContents).slideDown("normal", function (){
		setTimeout(function (){
			$(".showtips").slideUp("normal", function () {
				$(".showtips").text("").removeClass(tipsClass);
			});
		}, 3000);
	});
}