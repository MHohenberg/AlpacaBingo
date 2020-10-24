all:
	cp keywords.miniden keywords.org

release:
	rm -f keywords.miniden.gpg
	gpg --sign keywords.miniden
	git add keywords.miniden.gpg
	mkdir -p counters
	chmod a+rw counters
