php makepackage.php make
rm UNL_UCBCN_Frontend-*.tgz
pear package
pear install -f UNL_UCBCN_Frontend-0.0.1.tgz
pear run-scripts unl/UNL_UCBCN_Frontend
