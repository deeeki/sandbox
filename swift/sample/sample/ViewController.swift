import UIKit
import Alamofire
import Alamofire_SwiftyJSON

class ViewController: UICollectionViewController {
    
    var products: [String] = []
    
    override func viewDidLoad() {
        super.viewDidLoad()
        collectionView.registerClass(UICollectionViewCell.self, forCellWithReuseIdentifier: "cell")

        let cartButton = UIBarButtonItem(image: UIImage(named: "cart"), style: .Plain, target: self, action: "showCart:")
        navigationItem.rightBarButtonItem = cartButton

        Alamofire.request(.GET, "http://localhost:3000/products.json")
            .responseSwiftyJSON { (request, response, json, error) in
                self.products.removeAll(keepCapacity: false)
                for (key, subJson) in json {
                    self.products.append(Product(subJson).name)
                }
                self.collectionView.reloadData()
        }
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    override func collectionView(collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return products.count
    }
    
    override func collectionView(collectionView: UICollectionView, cellForItemAtIndexPath indexPath: NSIndexPath) -> UICollectionViewCell {
        let cell = collectionView.dequeueReusableCellWithReuseIdentifier("cell", forIndexPath: indexPath) as UICollectionViewCell
        cell.backgroundColor = UIColor.grayColor()
        let label = UILabel(frame: CGRectMake(0, 0, 50, 50))
        label.text = products[indexPath.row]
        cell.addSubview(label)
        return cell
    }
    
    override func collectionView(collectionView: UICollectionView, didSelectItemAtIndexPath indexPath: NSIndexPath) {
        let viewController = ProductsShowViewController()
        viewController.product = products[indexPath.row]
        navigationController?.pushViewController(viewController, animated: true)
    }

    func showCart(sender: AnyObject) {
        let viewController = CartsShowViewController()
        presentViewController(UINavigationController(rootViewController: viewController), animated: true, completion: nil)
    }
}
