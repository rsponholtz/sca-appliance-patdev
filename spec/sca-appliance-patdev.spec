# Copyright (C) 2013 SUSE LLC
# This file and all modifications and additions to the pristine
# package are under the same license as the package itself.
#
# norootforbuild
# neededforbuild
%define sca_common sca
%define sdp_common sdp

Name:         sca-appliance-patdev
Summary:      Supportconfig Analysis Appliance Pattern Development
URL:          https://bitbucket.org/g23guy/sca-appliance-patdev
Group:        Documentation/SuSE
Distribution: SUSE Linux Enterprise
Vendor:       SUSE Support
License:      GPL-2.0
Autoreqprov:  on
Version:      1.3
Release:      4
Source:       %{name}-%{version}.tar.gz
BuildRoot:    %{_tmppath}/%{name}-%{version}
Buildarch:    noarch
Requires:     apache2
Requires:     /usr/sbin/mysqld
Requires:     sca-appliance-common
Requires:     sca-patterns-base

%description
The SCA Appliance allows for adding custom patterns. This package
provides a database used to create pattern templates, speeding up
custom pattern development.

Authors:
--------
    Jason Record <jrecord@suse.com>

%prep
%setup -q

%build
gzip -9f man/*

%install
pwd;ls -la
rm -rf $RPM_BUILD_ROOT
install -d $RPM_BUILD_ROOT/etc/%{sca_common}
install -d $RPM_BUILD_ROOT/var/tmp/%{sca_common}
install -d $RPM_BUILD_ROOT/srv/www/htdocs/%{sdp_common}/docs-python
install -d $RPM_BUILD_ROOT/usr/sbin
install -d $RPM_BUILD_ROOT/usr/bin
install -d $RPM_BUILD_ROOT/usr/share/man/man1
install -d $RPM_BUILD_ROOT/usr/share/man/man5
install -d $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -d $RPM_BUILD_ROOT/var/archives
install -m 644 config/*.conf $RPM_BUILD_ROOT/etc/%{sca_common}
install -m 644 config/* $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -m 555 bin/pat $RPM_BUILD_ROOT/usr/bin
install -m 544 bin/sdpdb $RPM_BUILD_ROOT/usr/sbin
install -m 544 bin/setup-sdp $RPM_BUILD_ROOT/usr/sbin
install -m 644 docs-python/* $RPM_BUILD_ROOT/srv/www/htdocs/%{sdp_common}/docs-python
install -m 644 websdp/* $RPM_BUILD_ROOT/srv/www/htdocs/%{sdp_common}
install -m 400 websdp/db-config.php $RPM_BUILD_ROOT/srv/www/htdocs/%{sdp_common}
install -m 644 schema/* $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -m 644 docs/README* $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -m 644 man/*.1.gz $RPM_BUILD_ROOT/usr/share/man/man1
install -m 644 man/*.5.gz $RPM_BUILD_ROOT/usr/share/man/man5

%files
%defattr(-,root,root)
%dir %attr(775,root,users) /var/archives
%dir /srv/www/htdocs/%{sdp_common}
%dir /srv/www/htdocs/%{sdp_common}/docs-python
%dir /etc/%{sca_common}
%dir /var/tmp/%{sca_common}
%dir /usr/share/doc/packages/%{sca_common}
/usr/sbin/*
/usr/bin/*
%config /etc/%{sca_common}/*
%doc /usr/share/man/man1/*
%doc /usr/share/man/man5/*
%attr(-,wwwrun,www) /srv/www/htdocs/%{sdp_common}
%attr(-,wwwrun,www) /srv/www/htdocs/%{sdp_common}/docs-python
%doc /usr/share/doc/packages/%{sca_common}/*

%changelog
* Wed Jan 22 2014 jrecord@suse.com
- commented out debug statements to avoid xss

* Thu Jan 17 2014 jrecord@suse.com
- updated paths
- relocated files according to FHS

* Mon Jan 13 2014 jrecord@suse.com
- pat displays SPRSRC
- pat vars SPRSRC and DEFAULT_ARCHDIR can be set in the environment

* Wed Jan 08 2014 jrecord@suse.com
- sdpdb man page has correct name
- binaries installed in correct locations
- fixed hash plings in template php pages

* Fri Jan 03 2014 jrecord@suse.com
- added pat documentation
- added pat pattern tester
- separated sca-appliance-common files

* Thu Dec 20 2013 jrecord@suse.com
- separated as individual RPM package

