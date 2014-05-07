# spec file for package sca-appliance-patdev
#
# Copyright (C) 2014 SUSE LLC
#
# This file and all modifications and additions to the pristine
# package are under the same license as the package itself.
#
# Source developed at:
#  https://github.com/g23guy/sca-appliance-patdev
#
# norootforbuild
# neededforbuild
%define sca_common sca
%define sdp_common sdp

Name:         sca-appliance-patdev
Summary:      Supportconfig Analysis Appliance Pattern Development
URL:          https://github.com/g23guy/sca-appliance-patdev
Group:        System/Monitoring
License:      GPL-2.0
Autoreqprov:  on
Version:      1.3
Release:      16.1
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
gzip -9f man/*1
gzip -9f man/*5

%install
pwd;ls -la
rm -rf $RPM_BUILD_ROOT
install -d $RPM_BUILD_ROOT/etc/%{sca_common}
install -d $RPM_BUILD_ROOT/srv/www/htdocs/%{sdp_common}/docs-python
install -d $RPM_BUILD_ROOT/usr/sbin
install -d $RPM_BUILD_ROOT/usr/bin
install -d $RPM_BUILD_ROOT/usr/share/man/man1
install -d $RPM_BUILD_ROOT/usr/share/man/man5
install -d $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -d $RPM_BUILD_ROOT/var/log/archives
install -m 444 man/COPYING.GPLv2 $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
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
%dir %attr(775,root,users) /var/log/archives
%dir /srv/www/htdocs/%{sdp_common}
%dir /srv/www/htdocs/%{sdp_common}/docs-python
%dir /etc/%{sca_common}
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

