# This is a metadata profile template for the LVM2 system.
#
# It contains all configuration settings that are customizable by metadata
# profiles. To create a new metadata profile, select the settings you want
# to customize and add them in a new file named <profile_name>.profile.
# Then install the new profile in a directory as defined by config/profile_dir
# setting found in /etc/lvm/lvm.conf file.
#
# Metadata profiles can be referenced by using the --metadataprofile LVM2
# command line option.
#
# Refer to 'man lvm.conf' for further information about profiles and
# general configuration file layout.
#
allocation {
	thin_pool_zero=1
	thin_pool_discards="passdown"
	thin_pool_chunk_size_policy="generic"
#	thin_pool_chunk_size=128
}
activation {
	thin_pool_autoextend_threshold=100
	thin_pool_autoextend_percent=20
}
