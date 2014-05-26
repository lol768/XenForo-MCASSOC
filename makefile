all: addon-AssociationMc.xml
	mkdir -p upload/library/AssociationMc/; \
	cp --parents -r **/*.php upload/library/AssociationMc/; \
	cp *.php upload/library/AssociationMc/; \
	mkdir -p target; \
	rm target/*; \
	zip -r target/AssociationMc.zip LICENSE README.md addon-AssociationMc.xml upload; \
	rm -r upload;
	
