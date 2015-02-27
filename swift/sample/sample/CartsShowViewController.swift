import UIKit

class CartsShowViewController: UIViewController, UITableViewDelegate, UITableViewDataSource {

    var products: [String] = []

    override func viewDidLoad() {
        super.viewDidLoad()
        title = "cart"

        let defaults = NSUserDefaults.standardUserDefaults()
        products = defaults.objectForKey("cart") as [String]

        let tableView = UITableView(frame: view.frame)
        tableView.dataSource = self
        tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "cell")

        view.addSubview(tableView)
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }

    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return products.count
    }

    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("cell", forIndexPath: indexPath) as UITableViewCell
        cell.textLabel.text = products[indexPath.row]
        return cell
    }
}
