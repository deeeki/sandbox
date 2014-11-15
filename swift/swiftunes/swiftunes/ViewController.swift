//
//  ViewController.swift
//  swiftunes
//
//  Created by deeeki on 11/15/14.
//  Copyright (c) 2014 deeeki. All rights reserved.
//

import UIKit

class ViewController: UIViewController {

    @IBOutlet var appsTableView : UITableView?

    override func viewDidLoad() {
        super.viewDidLoad()
        
        searchItunesFor("Dragon Quest")
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    func searchItunesFor(searchTerm: String) {
        // The iTunes API wants multiple terms separated by + symbols, so replace spaces with + signs
        var itunesSearchTerm = searchTerm.stringByReplacingOccurrencesOfString(" ", withString: "+", options: NSStringCompareOptions.CaseInsensitiveSearch, range: nil)
        
        // Now escape anything else that isn't URL-friendly
        var escapedSearchTerm = itunesSearchTerm.stringByAddingPercentEscapesUsingEncoding(NSUTF8StringEncoding)
        var urlPath = "https://itunes.apple.com/search?term=\(escapedSearchTerm)&media=software"
        var url: NSURL = NSURL(string: urlPath)!
        var request: NSURLRequest = NSURLRequest(URL: url)
        var connection: NSURLConnection = NSURLConnection(request: request, delegate: self, startImmediately: false)!
        
        println("Search iTunes API at URL \(url)")
        
        connection.start()
    }
}

