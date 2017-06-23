# Auxiliary functions for the CLI-options-parser

function message {
	echo -e "$1" 1>&2;
	true;
}

function message_error {
	echo -e "$1" 1>&2;
	false;
}


function help { message "Usage:\n\tserver-start\n\tserver-status\n\tserver-stop\n\ttest-HTTP\n\ttest-unit"; }

function server-status { ps aux | grep 'php -S localhost:8000' | grep -v grep; }

function confirm {
	message=$1;
	read -p "$message " confirmed;
	if test -z "$confirmed";
		then message_error "Not confirmed";
		else message "Confirmed";
	fi;
}
