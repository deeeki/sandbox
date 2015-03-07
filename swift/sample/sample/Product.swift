import Foundation
import SwiftyJSON

class Product {
    var name: String
    var image_url: String
    
    init(_ attributes: Dictionary<String, NSObject?>) {
        name = attributes["name"] as String
        image_url = attributes["image_url"] as String
    }
    
    init(_ attributes: JSON) {
        name = attributes["name"].stringValue
        image_url = attributes["image_url"].stringValue
    }
}