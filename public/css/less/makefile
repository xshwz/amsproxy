all: ../site.css ../common.css ../proxy.css ../admin.css

../common.css: common.less bootstrap.less variables.less
	lessc common.less > $@

../site.css: site.less variables.less site/*.less
	lessc site.less > $@

../proxy.css: proxy.less variables.less proxy/*.less
	lessc proxy.less > $@

../admin.css: admin.less variables.less admin/*.less
	lessc admin.less > $@
