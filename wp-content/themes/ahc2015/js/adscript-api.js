/**
 * adscript-api.js
 *
 * Functions for use in the AdScript API docs
 */

( function() {
	var inheritedMethods, inheritedProperties, showHideInheritedMethodsLink, showHideInheritedPropertiesLink, toggleTextMethods, toggleTextProperties;

	inheritedMethods = document.getElementsByClassName('method');
	showHideInheritedMethodsLink = document.getElementById( 'showHideInheritedMethodsLink' );
	if ( showHideInheritedMethodsLink !== null && inheritedMethods.length > 0) {
		toggleTextMethods = showHideInheritedMethodsLink.getElementsByClassName("toggle-text")[0];
		showHideInheritedMethodsLink.addEventListener('click', function() {
			for ( i = 0, len = inheritedMethods.length; i < len; i++ ) {
				if (inheritedMethods[i].classList.contains("inherited"))
				{
					if (inheritedMethods[i].classList.contains("invisible"))
					{
						inheritedMethods[i].classList.remove("invisible");
						if (toggleTextMethods) toggleTextMethods.innerHTML = "hide";
					}
					else
					{
						inheritedMethods[i].classList.add("invisible");
						if (toggleTextMethods) toggleTextMethods.innerHTML = "show";
					}
				}
			}
		});
	}

	inheritedProperties = document.getElementsByClassName('property');
	showHideInheritedPropertiesLink = document.getElementById( 'showHideInheritedPropertiesLink' );
	if ( showHideInheritedPropertiesLink !== null && inheritedProperties.length > 0 ) {
		toggleTextProperties = showHideInheritedPropertiesLink.getElementsByClassName("toggle-text")[0];
		showHideInheritedPropertiesLink.addEventListener('click', function() {
			for ( i = 0, len = inheritedProperties.length; i < len; i++ ) {
				if (inheritedProperties[i].classList.contains("inherited"))
				{
					if (inheritedProperties[i].classList.contains("invisible"))
					{
						inheritedProperties[i].classList.remove("invisible");
						if (toggleTextProperties) toggleTextProperties.innerHTML = "hide";
					}
					else
					{
						inheritedProperties[i].classList.add("invisible");
						if (toggleTextProperties) toggleTextProperties.innerHTML = "show";
					}
				}
			}
		});
	}
} )();
