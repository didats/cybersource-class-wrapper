# Cybersource class wrapper
PHP Class to integrate cybersource with easy configuration. I have spent hours trying the SDK without any success. This class intended to make it easy for you and no more wasting hours integrating with Cybersource.

## Before using the class
1. You gonna need an account, and login to their business centre here:  
https://ebctest.cybersource.com/ebctest/Home.do
2. Click on the **Tools & Settings**, and go to **Profiles**. You need to create an active profile to start
3. Enter the **profile name**, Integration method is **Web/Mobile**, Tick on **Payment Tokenizer**, **Decision Manager**, **Enable Verbose Data**, and **Generate Device Fingerprint**
4. Click on Create button.
5. You will need to write down the **Profile ID** below the Profile Name. 
6. Complete the **Payment Setting** section
7. Go to **Security**, and **Create New Key**. Use the default data to submit
8. Write down the **Access Key** and **Secret Key**
9. Go to **Customer Response Page** and Enter the Return URL and Cancel Return URL as well to any URL you wished for.
10. Make sure your new profile is **Active**. We only need 3 variables here. **Profile ID**, **Access Key** and **Secret Key**

## Using the class
Check `sample.php` for using the class.

### License
You are free to use on any project, including commercial project. You may not needed to mention my name. Just do what you want to do, but please do not sell it.

### Developer
**Didats Triadi**  
Malang, Indonesia  
http://rimbunesia.com