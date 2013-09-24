all: ../bootstrap-custom.css ../amsProxy.css

../bootstrap-custom.css: bootstrap-custom.less variables.less
	lessc $< > $@

../amsProxy.css: amsProxy.less variables.less courseLine.less courseTable.less login.less datepicker.less admin.less
	lessc $< > $@
