# Copyright (C) 2013 SUSE LLC
# This file and all modifications and additions to the pristine
# package are under the same license as the package itself.
#
# norootforbuild
# neededforbuild
%define sca_common sca

Name:         sca-appliance-patdev
Summary:      Supportconfig Analysis Appliance Pattern Development
Group:        Documentation/SuSE
Distribution: SUSE Linux Enterprise
Vendor:       SUSE Support
License:      GPLv2
Autoreqprov:  on
Version:      1.2
Release:      1.140103.PTF.1
Source:       %{name}-%{version}.tar.gz
BuildRoot:    %{_tmppath}/%{name}-%{version}
Buildarch:    noarch
Requires:     apache2
Requires:     /usr/sbin/mysqld
Requires:     sca-appliance-common
Requires:     sca-patterns-base

%description
Database to keep track of custom SCA patterns

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
install -d $RPM_BUILD_ROOT/etc/opt/%{sca_common}
install -d $RPM_BUILD_ROOT/opt/%{sca_common}/bin
install -d $RPM_BUILD_ROOT/srv/www/htdocs/sdp
install -d $RPM_BUILD_ROOT/usr/sbin
install -d $RPM_BUILD_ROOT/usr/share/man/man1
install -d $RPM_BUILD_ROOT/usr/share/man/man5
install -d $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -d $RPM_BUILD_ROOT/var/opt/%{sca_common}
install -m 644 config/*.conf $RPM_BUILD_ROOT/etc/opt/%{sca_common}
install -m 644 config/* $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -m 544 bin/* $RPM_BUILD_ROOT/opt/%{sca_common}/bin
install -m 544 bin/* $RPM_BUILD_ROOT/usr/sbin
install -m 644 websdp/* $RPM_BUILD_ROOT/srv/www/htdocs/sdp
install -m 400 websdp/db-config.php $RPM_BUILD_ROOT/srv/www/htdocs/sdp
install -m 644 schema/* $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -m 644 docs/* $RPM_BUILD_ROOT/usr/share/doc/packages/%{sca_common}
install -m 644 man/*.1.gz $RPM_BUILD_ROOT/usr/share/man/man1
install -m 644 man/*.5.gz $RPM_BUILD_ROOT/usr/share/man/man5

%files
%defattr(-,root,root)
%dir /opt
%dir /etc/opt
%dir /var/opt
%dir /srv/www/htdocs/sdp
%dir /opt/%{sca_common}
%dir /opt/%{sca_common}/bin
%dir /etc/opt/%{sca_common}
%dir /var/opt/%{sca_common}
%dir /usr/share/doc/packages/%{sca_common}
/usr/sbin/*
/opt/%{sca_common}/bin/*
%config /etc/opt/%{sca_common}/*
%doc /usr/share/man/man1/*
%doc /usr/share/man/man5/*
%attr(-,wwwrun,www) /srv/www/htdocs/sdp
%doc /usr/share/doc/packages/%{sca_common}/*

%changelog
* Fri Jan 03 2014 jrecord@suse.com
- separated sca-appliance-common files

* Thu Dec 20 2013 jrecord@suse.com
- separated as individual RPM package

