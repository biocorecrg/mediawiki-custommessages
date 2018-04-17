# CustomMessages

Extension for allowing easy input of JavaScript messages that can be mantained in an easy way


## Configuration

    // Namespaces to be used for storing information
    $wgCustomMessagesNamespaces = array( NS_HELP );

    // Namespace type. Default is ini style. Only one available so far.
    $wgCustomMessagesNamespacesTypes = array( NS_HELP  => "ini" );

# Examples 

In Help:Event

    ;add=Clicking here adds new features
    ;properties=This option allows the acquisition of new properties

The two examples above are available via

* data-cm-help-event-add
* data-cm-help-event-properties





