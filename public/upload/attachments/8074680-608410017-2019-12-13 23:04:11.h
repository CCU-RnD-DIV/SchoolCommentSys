#ifndef pattern_h
#define pattern_h
const char *const hex_bin[]={"0000","0001","0010","0011","0100","0101","0110",
		"0111","1000","1001","1010","1011","1100","1101","1110","1111"};
const char *hex_to_binary(char c){
	if(c>='0'&&c<='9'){
		return hex_bin[c-'0'];
	}
	else if(c>='A'&&c<='F'){
		return hex_bin[c-'A'+10];
	}
	else if(c>='a'&&c<='f'){
		return hex_bin[c-'a'+10];
	}
	return NULL;
}
int binary_to_int(char *expression,int len){
    int result=0;
    for(int i=len-1;i>=0;i--){
        if(expression[len-1-i]=='1'){
            result+=pow(2,i);
        }
    }
    return result;
}
#endif
