<?php
class EditcountHooks {
	public static function onSkinTemplateNavigation( SkinTemplate &$skinTemplate, array &$links ) {
	$title = $skinTemplate->getTitle();
	if ( $title->getNamespace() !== NS_USER && $title->getNamespace() !== NS_USER_TALK ) {
		return;
	}
	$user = User::NewFromName( $title->getBaseText() );
	if ( !$user ) {
		// user is anon
		return true;
	}
	$edits = $user->getEditCount();
	if ( $edits == null ) {
		$edits = 0;
	}
	$request = $skinTemplate->getRequest();
	$action = $request->getText( 'action' );
	$links['namespaces']['editcount'] = array(
		'text' => wfMessage( 'editcount_tab' )->params( $edits )->escaped(),
		'href' => SpecialPage::getTitleFor( 'Editcount' )->getLocalUrl( ['username' => $user] )
	);
	return true;
}
}